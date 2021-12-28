<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use App\Models\OpNote;
use Livewire\Component;

class OperationalNotes extends Component
{
    public $machine = null;
    public $opNotes = null;
    public $m = null;

    public function mount()
    {
        $this->machine = Machine::active()->with('opnote')->get();
    }

    public function getNotes()
    {
        $this->opNotes = $this->machine->where('id', $m)->opnote;
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes');
    }
}
