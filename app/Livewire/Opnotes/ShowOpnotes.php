<?php

namespace App\Livewire\Opnotes;

use App\Models\OpNote;
use Livewire\Component;

class ShowOpnotes extends Component
{
    public $machineId;

    /**
     * @param int $machineId
     *
     * Machine ID to retrieve operational notes for.
     */
    public function mount(?int $machineId)
    {
        $this->machineId = $machineId;
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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
