<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\OpNoteStoreRequest;
use RadDB\Http\Requests\OpNoteUpdateRequest;

class OpNoteController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         $this->middleware('auth')->only([
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        if (is_null($id)) {
            $machineID = null;
            $opNotes = null;
            $machines = Machine::->active()->get();
        } else {
            $machineID = $id;
            $machines = Machine::find($machineID);
            $opNotes = OpNote::where('machine_id', $machineID)->get();
        }
        return view('opnotes.opnote_create', [
            'machineID' => $machineID,
            'machines' => $machines,
            'opnotes' => $opNotes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OpNoteStoreRequest $request)
    {
        // Check if action is allowed
        $this->authorize(OpNote::class);

        $opnote = new OpNote();
        $opnote->machine_id = $request->machineId;
        $opnote->note = $request->note;

        $saved = $opnote->save();
        if ($saved) {
            $message = 'Operational note '.$opnote->id.' added.';
            Log::info($message);

            $status = "success";
            $message = "Operational note added";
        } else {
            $status = "fail";
            $message = "Error adding operational note";
        }
        return redirect()->route('opnotes.show', $opnote->machine_id)
            ->with($status, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine = Machine::find($machineID);
        $opNotes = OpNote::where('machine_id', $id);

        return view('opnotes.opnote_show', [
            'machine' => $machine,
            'opnotes' => $opNotes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opNote = OpNote::find($id);

        return view('opnotes.opnote_edit' {
            'opnote' => $opnote,
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OpNoteUpdateRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(OpNote::class);

        $opnote = OpNote::find($id);
        $opnote->note = $request->note;
        $saved = $opnote->save();
        if ($saved) {
            $message = 'Operational note '.$opnote->id.' updated.';
            Log::info($message);

            $status = "success";
            $message = "Operational note updated";
        } else {
            $status = "fail";
            $message = "Error updating operational note";
        }
        return redirect()->route('opnotes.show', $opnote->machine_id)
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
