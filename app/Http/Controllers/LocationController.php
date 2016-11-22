<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Location;
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

        return redirect('/admin/locations/');
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

        return redirect('/admin/locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
