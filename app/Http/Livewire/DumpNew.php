<?php

namespace App\Http\Livewire;

use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DumpNew extends Component
{
    public $connection = [
        'host' => null,
        'username' => null,
        'password' => null,
        'database' => null,
        'name' => null
    ];

    protected $rules = [
        'connection.host' => ['required'],
        'connection.username' => ['required', 'string', 'max:255'],
        'connection.password' => ['required'],
    ];

    protected $messages = [
        'connection.host.required' => 'The Host is required',
        'connection.username.required' => 'The Username is required',
        'connection.username.max' => 'The Username cannot exceed 255 characters',
        'connection.password.required' => 'The Password is required',
    ];

    public $connectionStatus = false;

    public function test()
    {
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
        } catch (\Exception $e) {
            $this->connectionStatus = false;
        } finally {
            $this->emit('testConnectionStatus');
        }
    }

    public function save()
    {
        $this->validate(
            ['connection.name' => ['required', 'string', 'max:255']],
            [
                'connection.name.required' => 'The Connection Name is required',
                'connection.name.max' => 'The Connection name cannot exceed 255 characters'
            ],
            ['connection.name' => 'Connection Name']
        );

        Connection::create($this->connection);
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.dump-new')
            ->layout('layouts.app', ['header' => 'New Connection']);
    }
}
