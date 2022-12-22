<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\Machine;
use App\Models\OpNote;
use Livewire\Component;

class OperationalNotes extends Component
{
    public \Illuminate\Database\Eloquent\Collection $machines;
    public \Illuminate\Database\Eloquent\Collection $opNotes;
    public int $selectedMachine;
    public string $note;

    public function mount(): void
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

    public function updatedSelectedMachine(): void
    {
        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();
    }

    /**
     * @param int    $id
     * @param string $note
     */
    public function addNote($id, $note): void
    {
        OpNote::create([
            'machine_id' => $id,
            'note'       => $note,
        ]);

        $this->note = '';
        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();

        session()->flash('message', 'Op note added.');
    }

    public function deleteNote($id): void
    {
        OpNote::find($id)->delete();

        $this->opNotes = OpNote::where('machine_id', $this->selectedMachine)->get();

        session()->flash('message', 'Op note '.$id.' removed.');
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.opnotes.operational-notes')->extends('layouts.app');
    }
}
