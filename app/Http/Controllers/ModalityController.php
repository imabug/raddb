<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Modality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the modalities
        $modalities = Modality::get();

        return view('admin.modalities_index', [
            'modalities' => $modalities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Add a new modality to the database.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'modality' => 'required|string|max:25',
        ]);

        $modality = new Modality();
        $modality->modality = $request->modality;
        $saved = $modality->save();
        if ($saved) {
            $message = 'Modality '.$modality->modality.' added.';
            Log::info($message);
        }

        return redirect()->route('modalities.index');
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
        //
    }

    /**
     * Display a listing of machines grouped by modality
     * URI: /modalities
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showModalityIndex()
    {
        // Fetch a list of all the machines grouped by modality
        // Use the modality field to group the collection by modality
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('modality.modality');

        return view('modalities.index', [
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific modality
     * URI: /modalities/$id
     * Method: GET.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showModality($id)
    {
        // Show a list of machines for modality $id
        $modality = Modality::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality($id)
            ->get();

        return view('modalities.modality', [
            'modality' => $modality,
            'machines' => $machines,
            'n'        => $machines->count(),
        ]);
    }

    /**
     * Show the form for editing a modality
     * URI: /admin/modalities/$id/edit
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modality = Modality::findOrFail($id);

        return view('admin.modalities_edit', [
            'modality' => $modality,
        ]);
    }

    /**
     * Update the modality.
     * URI: /admin/modalities/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'modality' => 'required|string|max:20',
        ]);

        $modality = Modality::find($id);

        $modality->modality = $request->modality;

        $saved = $modality->save();
        if ($saved) {
            $message = 'Modality '.$modality->id.' edited.';
            Log::info($message);
        }

        return redirect()->route('modalities.index');
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
        $modality = Modality::find($id);

        $deleted = $modality->delete();
        if ($deleted) {
            $message = 'Modality '.$modality->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('modalities.index');
    }
}
