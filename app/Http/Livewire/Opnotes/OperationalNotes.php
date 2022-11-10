<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use App\Models\OpNote;
use Livewire\Component;

class OperationalNotes extends Component
{
    public $machines;
    public $opNotes;
    public $selectedMachine;
    public $note;

    public function mount()
    {
        $this->machines = Machine::active()
            ->with('opnote')
            ->orderBy('description')
            ->get();
    }

    public function updatedSelectedMachine()
    {
        $this->opNotes = $this->machines->find($this->selectedMachine)->opnote()->get();
    }

    public function addNote($id, $note)
    {
        OpNote::create([
            'machine_id' => $id,
            'note'       => $note,
        ]);

        $this->note = '';

        session()->flash('message', 'Op note added.');
    }

    public function deleteNote($id)
    {
        OpNote::find($id)->delete();

        session()->flash('message', 'Op note '.$id.' removed.');
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes', [
            'machines' => $this->machines,
        ])->extends('layouts.app');
    }
}
