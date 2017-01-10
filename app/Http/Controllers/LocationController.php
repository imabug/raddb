<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Location;
use RadDB\Machine;
use RadDB\Http\Requests;

class LocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the locations
        $locations = Location::get();

        return view('admin.locations_index', [
            'locations' => $locations
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
     * Add a new location to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'location' => 'required|string|max:20',
        ]);

        $location = new Location;
        $location->location = $request->location;
        $location->save();

        return redirect()->route('locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display a listing of machines by location
     * URI: /locations
     * Method: GET
     *
     * @return \Illuminate\Http\Response
     */
    public function showLocationIndex()
    {
        // Fetch a list of all the machines grouped by location
        // Use the location field to group the collection by location
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('location.location');

        return view('locations.index', [
            'machines' => $machines
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /locations/$id
     * Method: GET
     *
     * @param string $id
     * @return \\Illuminate\Http\Response
     */
    public function showLocation($id)
    {
        // Show a list of machines for location $id
        $location = Location::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->location($id)
            ->get();

        return view('locations.location', [
            'location' => $location,
            'machines' => $machines,
            'n' => $machines->count()
        ]);
    }

    /**
     * Show the form for editing a location.
     * URI: /admin/locations/$id/edit
     * Method: GET
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);

        return view('admin.locations_edit', [
            'location' => $location
        ]);
    }

    /**
     * Update the location.
     * URI: /admin/locations/$id
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'location' => 'required|string|max:100'
        ]);

        $location = Location::find($id);

        $location->location = $request->location;

        $location->save();

        return redirect()->route('locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        $location->delete();
        return redirect()->route('locations.index');
    }
}
