<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpNoteStoreRequest;
use App\Http\Requests\OpNoteUpdateRequest;
use App\Models\Machine;
use App\Models\OpNote;
use Illuminate\Support\Facades\Log;

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
        $this->middleware('auth')->only([
            'create',
            'edit',
            'store',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating an operational note for machine $machineId.
     * URI: /opnotes/{$machineId}/create
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create($machineId = null)
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
     * URI: /opnotes
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OpNoteStoreRequest $request)
    {
        // Check if action is allowed
        $this->authorize(OpNote::class);

        $opNote = new OpNote();
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
     * URI: /opnotes/$machineId
     * Method: GET.
     *
     * @param int $machineId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $machineId)
    {
        $machine = Machine::findOrFail($machineId); // Return HTTP 404 if no machine is found

        return view('opnotes.opnote_show', [
            'machine' => $machine,
            'opNotes' => $machine->opnote,
        ]);
    }

    /**
     * Show the form for editing an operational note.
     * URI: /opnotes/$id/edit
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('opnotes.opnote_edit', [
            'opNote' => OpNote::findOrFail($id),
        ]);
    }

    /**
     * Update the operational note.
     * URI: /opnotes/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OpNoteUpdateRequest $request, int $id)
    {
        // Check if action is allowed
        $this->authorize(OpNote::class);

        $opNote = OpNote::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
