<?php

namespace App\Http\Livewire;

use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class DumpShow extends Component
{
    public $connection;
    public $connectionStatus = true;
    public $updatedConnection = false;
    public $hash;
    public $dummy = null;

    protected $rules = [
        'connection.host' => ['required'],
        'connection.username' => ['required', 'string', 'max:255'],
        'connection.password' => ['required'],
        'connection.name' => ['required'],
    ];

    public function mount(Connection $connection)
    {
        $this->connection = $connection;
        $this->hash = $this->connection->password;
    }

    public function updated($property)
    {
        if($property === 'dummy') {
            $this->connection->password = $this->dummy;
            if(Hash::check($this->connection->password, $this->hash)) {
                $this->updatedConnection = false;
            }
            else {
                $this->updatedConnection = true;
            }
        }
        else {
            $propertyName = explode('.', $property)[1];
            if($propertyName !== 'name') {
                if(!$this->connection->isDirty($propertyName)) {
                    $this->updatedConnection = false;
                }
                else {
                    $this->updatedConnection = true;
                }
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
        $this->emit('updated');
    }

    public function render()
    {
        return view('livewire.dump-show')
            ->layout('layouts.app');
    }
}
