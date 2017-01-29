<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Location;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         // Exclude these methods from auth middlware
         $this->middleware('auth')->except([
             'showLocation',
             'showLocationIndex',
         ]);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the locations
        return view('admin.locations_index', [
            'locations' => Location::get(),
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
        // Check if action is allowed
        $this->authorize(Location::class);

        $location = new Location();
        $location->location = $request->location;
        if ($location->save()) {
            $message = 'New location: '.$location->location.' added.';
            Log::info($message);
        }

        return redirect()->route('locations.index');
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
     * Display a listing of machines by location
     * URI: /locations
     * Method: GET.
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
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /locations/$id
     * Method: GET.
     *
     * @param string $id
     *
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
        return view('admin.locations_edit', [
            'location' => Location::findOrFail($id),
        ]);
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
        // Check if action is allowed
        $this->authorize(Location::class);

        $location = Location::find($id);

        $location->location = $request->location;

        if ($location->save()) {
            $message = 'Location '.$location->id.' edited.';
            Log::info($message);
        }

        return redirect()->route('locations.index');
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
        $this->authorize(Location::class);
        $location = Location::find($id);

        if ($location->delete()) {
            $message = 'Location '.$location->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('locations.index');
    }
}
