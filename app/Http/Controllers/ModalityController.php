<?php

namespace RadDB\Http\Controllers;

use DB;
use Charts;
use RadDB\Machine;
use RadDB\Modality;
use RadDB\Http\Requests\ModalityRequest;

class ModalityController extends Controller
{
    /**
     * Display a listing of machines grouped by modality
     * URI: /machines/modalities
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch a list of all the machines grouped by modality
        // Use the modality field to group the collection by modality
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('modality.modality');

        // Create a bar chart of the number of machines for each modality
        foreach ($machines as $key=>$modality) {
            $chartData[] = count($modality);
        }
        // Make an array of some random colours
        $numMachines = $machines->count();
        for ($i = 0; $i <= $numMachines; $i++) {
            $chartColors[] = '#'.str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        $machinesModalityChart = Charts::create('pie', 'google')
            ->title('Number of machines by modality')
            ->elementLabel('Number of machines')
            ->colors($chartColors)
            ->labels($machines->keys()->toArray())
            ->values($chartData);

        return view('machine.modalities.index', [
            'machines' => $machines,
            'machinesModalityChart' => $machinesModalityChart,
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
    }

    /**
     * Display a listing of machines for a specific modality
     * URI: /machines/modalities/$id
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // Show a list of machines for modality $id
        $modality = Modality::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality($id)
            ->get();

        return view('machine.modalities.modality', [
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
    }
}
