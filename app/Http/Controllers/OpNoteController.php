<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpNoteStoreRequest;
use App\Http\Requests\OpNoteUpdateRequest;
use App\Models\Machine;
use App\Models\OpNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OpNoteController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only include these methods in the auth middlware
        // $this->middleware('auth')->only([
        //     'create',
        //     'edit',
        //     'store',
        //     'update',
        //     'destroy',
        // ]);
    }

    /**
     * Show the form for creating an operational note for machine $machineId.
     *
     * If $machineId has existing operational notes, these are displayed by the
     * App\Livewire\Opnotes\ShowOpnotes component
     *
     * URI: /opnotes/{$machineId}/create
     *
     * Method: GET.
     *
     * @param string $machineId
     */
    public function create($machineId = null): View
    {
        if (is_null($machineId)) {
            // No machine was specified. Pull a list of active machines to use in the form
            $machines = Machine::active()->get();
            $opNotes = null;
        } else {
            // A machine was specified. Pull the machine model and any existing operational notes
            $machines = Machine::find($machineId);
            $opNotes = $machines->opnote;
        }

        return view('opnotes.opnote_create', [
            'machineId' => $machineId,
            'machines'  => $machines,
            'opNotes'   => $opNotes,
        ]);
    }

    /**
     * Store a new operational note.
     *
     * Form data is validated by App\Http\Requests\OpNoteStoreRequest.  User is
     * redirected to the list of operational notes upon completion.
     *
     * URI: /opnotes
     *
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(OpNoteStoreRequest $request, OpNote $opNote): RedirectResponse
    {
        $message = '';
        $status = '';

        // Check if action is allowed
        // $this->authorize(OpNote::class);

        $opNote->machine_id = $request->machineId;
        $opNote->note = $request->note;

        if ($opNote->save()) {
            $status = 'success';
            $message = 'Operational note '.$opNote->id.' added.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error adding operational note.';
            Log::error($message);
        }

        return redirect()
            ->route('opnotes.show', $opNote->machine_id)
            ->with($status, $message);
    }

    /**
     * Display operational notes for machine $machineId.
     *
     * URI: /opnotes/$machineId
     *
     * Method: GET.
     *
     * @param string $machineId
     */
    public function show(int $machineId): View
    {
        // Return HTTP 404 if no machine is found
        $machine = Machine::findOrFail((int) $machineId);

        return view('opnotes.opnote_show', [
            'machine' => $machine,
            'opNotes' => $machine->opnote,
        ]);
    }

    /**
     * Show the form for editing an operational note.
     *
     * URI: /opnotes/$id/edit
     *
     * Method: GET.
     *
     * @param string $id
     */
    public function edit($id): View
    {
        return view('opnotes.opnote_edit', [
            'opNote' => OpNote::findOrFail((int) $id),
        ]);
    }

    /**
     * Update the operational note.
     *
     * Form data is validated by App\Http\Requests\OpNoteUpdateRequest.  User is
     * redirected to the list of operational notes after completion.
     *
     * URI: /opnotes/$id
     *
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     */
    public function update(OpNoteUpdateRequest $request, string $id): RedirectResponse
    {
        $message = '';
        $status = '';

        // Check if action is allowed
        // $this->authorize(OpNote::class);

        $opNote = OpNote::findOrFail((int) $id);
        $opNote->note = $request->note;

        if ($opNote->save()) {
            $status = 'success';
            $message = 'Operational note '.$opNote->id.' updated.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error updating operational note.';
            Log::error($message);
        }

        return redirect()
            ->route('opnotes.show', $opNote->machine_id)
            ->with($status, $message);
    }
}
