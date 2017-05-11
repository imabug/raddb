<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Location;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\LocationRequest;

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
