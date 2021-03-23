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

        return view('machine.manufacturers.index', [
            'machines' => $machines,
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
