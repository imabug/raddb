<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use Livewire\Component;

class OperationalNotes extends Component
{
    public $machines;
    public $opNotes;
    public int $selectedMachine;

    public function mount()
    {
        $this->selectedMachine = 0;
        $this->machines = Machine::active()->with('opnote')->get();
    }

    public function getNotes()
    {
        $this->opNotes = $this->machines->find($this->selectedMachine)->opnote()->get();
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes')
            ->extends('layouts.app')
            ->section('content');
    }
}
