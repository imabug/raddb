<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use Livewire\Component;

class OperationalNotes extends Component
{
    public $machine;
    public $opNotes;
    public $mNotes;

    public function mount()
    {
        $this->machine = Machine::active()->with('opnote')->get();
    }

    public function getNotes()
    {
        $this->opNotes = Machine::find($this->mNotes)->opnote()->get();
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes')
            ->extends('layouts.app')
            ->section('content');
    }
}
