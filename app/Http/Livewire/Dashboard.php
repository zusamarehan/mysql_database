<?php

namespace App\Http\Livewire;

use App\Models\Connection;
use Livewire\Component;

class Dashboard extends Component
{
    public $connections;

    public function destroy(Connection $connection)
    {
        $connection->delete();
        $this->connections->fresh();
    }

    public function render()
    {
        $this->connections = Connection::query()
            ->with('user')
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('livewire.dashboard')
            ->layout('layouts.app', ['header' => 'Dashboard']);
    }
}
