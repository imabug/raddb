<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Modality;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\ModalityRequest;

class ModalityController extends Controller
{
    /**
     * Show a list of the modalities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modalities_index', [
            'modalities' => Modality::get(),
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
    public function store(ModalityRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Modality::class);

        $modality = new Modality();
        $modality->modality = $request->modality;
        if ($modality->save()) {
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
        return view('admin.modalities_edit', [
            'modality' => Modality::findOrFail($id),
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
    public function update(ModalityRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(Modality::class);

        $modality = Modality::find($id);

        $modality->modality = $request->modality;

        if ($modality->save()) {
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
        // Check if action is allowed
        $this->authorize(Modality::class);

        $modality = Modality::find($id);

        if ($modality->delete()) {
            $message = 'Modality '.$modality->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('modalities.index');
    }
}
