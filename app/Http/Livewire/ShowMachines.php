<?php

namespace App\Http\Livewire;

use App\Http\Livewire\MachineListTable;
use App\Http\Models\Machine;
use Livewire\Component;

class ShowMachines extends Component
{
    public function render()
    {
        return view('livewire.show-machines');
    }
}
