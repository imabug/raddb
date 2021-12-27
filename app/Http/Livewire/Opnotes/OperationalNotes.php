<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use App\Models\OpNote;
use Livewire\Component;

class OperationalNotes extends Component
{
    public $machine = null;
    public $opNotes = null;

    public function mount(?int $machineId = null)
    {
        if (!is_null($machineId)) {
            $this->machine = Machine::find($machineId);
            $this->opNotes = OpNote::where('machine_id', $machineId)->get();
        } else {
            $this->machine = Machine::active()->get();
        }
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes');
    }
}
