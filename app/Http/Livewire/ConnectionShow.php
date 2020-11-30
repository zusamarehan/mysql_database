<?php

namespace App\Http\Livewire;

use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ConnectionShow extends Component
{
    public $connection;
    public $connectionStatus = true;
    public $updatedConnection = false;
    public $hash;

    protected $rules = [
        'connection.host' => ['required'],
        'connection.username' => ['required', 'string', 'max:255'],
        'connection.password' => ['required'],
        'connection.name' => ['required'],
    ];

    public function mount(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->password = base64_decode(env('APP_KEY').$this->connection->password.env('APP_KEY'));
    }

    public function updated($property)
    {
        $propertyName = explode('.', $property)[1];
        if($propertyName !== 'name') {
            if($propertyName === 'password') {
                $hash = base64_encode(env('APP_KEY').$this->connection->password.env('APP_KEY'));
                if($this->connection->getOriginal('password') == $hash) {
                    $this->updatedConnection = false;
                }
                else {
                    $this->updatedConnection = true;
                }
            }
            else if(!$this->connection->isDirty($propertyName)) {
                $this->updatedConnection = false;
            }
            else {
                $this->updatedConnection = true;
            }
        }

    }

    public function test()
    {
        $validator = Validator::make(
            [$this->connection->host, $this->connection->username, $this->connection->password],
            [
                'connection.host' => ['required'],
                'connection.username' => ['required', 'string', 'max:255'],
                'connection.password' => ['required'],
            ]
        );

        $this->validate();

        config([
            'database.connections.testConnection.host' => $this->connection['host'],
            'database.connections.testConnection.username' => $this->connection['username'],
            'database.connections.testConnection.password' => $this->connection['password'],
        ]);

        DB::purge('testConnection');
        DB::reconnect('testConnection');
        // Test database connection
        try {
            DB::connection('testConnection')->getPdo();
            $this->connectionStatus = true;
            $this->updatedConnection = false;
        } catch (\Exception $e) {
            $this->connectionStatus = false;
        } finally {
            $this->emit('testConnectionStatus');
        }
    }

    public function update()
    {
        $this->validate(
            ['connection.name' => ['required', 'string', 'max:255']],
            [
                'connection.name.required' => 'The Connection Name is required',
                'connection.name.max' => 'The Connection name cannot exceed 255 characters'
            ],
            ['connection.name' => 'Connection Name']
        );

        $this->connection->update();
        $this->connection->password = base64_decode(env('APP_KEY').$this->connection->password.env('APP_KEY'));
        $this->emit('updated');
    }

    public function render()
    {
        return view('livewire.connection-show')
            ->layout('layouts.app');
    }
}
