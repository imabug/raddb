<?php

namespace App\Http\Livewire\Opnotes;

use App\Models\OpNote;
use Livewire\Component;

class ShowOpnotes extends Component
{
    /**
     * @param int $machineId
     *
     * Machine ID to retrieve operational notes for.
     */
    public $machineId;

    public function mount(int $machineId = null)
    {
        $this->machineId = $machineId;
    }

    public function setMachineId()
    {

    }

    public function render()
    {
        if (!is_null($this->machineId)) {
            $opNotes = OpNote::where('machine_id', $this->machineId)
                ->get();
        } else {
            $opNotes = null;
        }
        return view('livewire.opnotes.show-opnotes', [
            'opNotes' => $opNotes,
        ]);
    }
}
