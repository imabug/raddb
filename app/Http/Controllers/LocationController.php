<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Location;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of machines by location
     * URI: /machines/locations
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
            ->groupBy('location.location');

        return view('machine.locations.index', [
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

    /**
     * Add a new location to the database.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /machines/locations/$id
     * Method: GET.
     *
     * @param string $id
     *
     * @return \\Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show a list of machines for location $id
        $location = Location::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->location($id)
            ->get();

        return view('machine.locations.location', [
            'location' => $location,
            'machines' => $machines,
            'n'        => $machines->count(),
        ]);
    }

    /**
     * Show the form for editing a location.
     * URI: /admin/locations/$id/edit
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
     * Update the location.
     * URI: /admin/locations/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, $id)
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
