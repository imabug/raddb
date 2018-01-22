<?php

namespace RadDB\Http\Controllers;

use Charts;
use RadDB\Machine;
use RadDB\Manufacturer;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of machines by manufacturer
     * URI: /machines/manufacturers
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch a list of all the machines grouped by location
        // Use the location field to group the collection by location
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('manufacturer.manufacturer');

        // Create a bar chart of the number of machines for each modality
        foreach ($machines as $key=>$modality) {
            $chartData[] = count($modality);
        }
        // Make an array of some random colours
        $numMachines = $machines->count();
        for ($i = 0; $i <= $numMachines; $i++) {
            $chartColors[] = '#'.str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        $machinesManufChart = Charts::create('pie', 'google')
            ->title('Number of machines by manufacturer')
            ->elementLabel('Number of machines')
            ->colors($chartColors)
            ->labels($machines->keys()->toArray())
            ->values($chartData);

        return view('machine.manufacturers.index', [
            'machines' => $machines,
            'machinesManufChart' => $machinesManufChart,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(ManufacturerRequest $request)
    {
    }

    /**
     * Display a listing of machines for a specific manufacturer
     * URI: /machine/manufacturers/$id
     * Method: GET.
     *
     * @param int $id
     *
     * @return \\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // Show a list of machines for location $id
        $manufacturer = Manufacturer::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->manufacturer($id)
            ->get();

        return view('machine.manufacturers.manufacturer', [
            'manufacturer' => $manufacturer,
            'machines'     => $machines,
            'n'            => $machines->count(),
        ]);
    }

    /**
     * Show the form for editing a manufacturer
     * URI: /admin/manufacturers/$id/edit
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
     * Update the manufacturer.
     * URI: /admin/manufacturers/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ManufacturerRequest $request, $id)
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
