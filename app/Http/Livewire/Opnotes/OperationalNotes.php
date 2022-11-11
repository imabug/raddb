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

        // Set the first machine in the list as the default
        $this->selectedMachine = $this->machines
            ->first()
            ->id;

        // Get the opnotes for $this->selectedMachine
        $this->opNotes = $this->machines
            ->find($this->selectedMachine)
            ->opnote;
    }

    public function updatedSelectedMachine()
    {
        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();
    }

    public function addNote($id, $note)
    {
        OpNote::create([
            'machine_id' => $id,
            'note'       => $note,
        ]);

        $this->note = '';
        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();

        session()->flash('message', 'Op note added.');
    }

    public function deleteNote($id)
    {
        OpNote::find($id)->delete();

        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();

        session()->flash('message', 'Op note '.$id.' removed.');
    }

    public function render()
    {
        return view('livewire.opnotes.operational-notes')->extends('layouts.app');
    }
}
