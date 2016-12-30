<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Manufacturer;
use RadDB\Machine;
use RadDB\Http\Requests;

class ManufacturerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the manufacturers
        $manufacturers = Manufacturer::get();

        return view('admin.manufacturers_index', [
            'manufacturers' => $manufacturers
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
     * Add a new manufacturer to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'manufacturer' => 'required|string|max:20',
        ]);

        $manufacturer = new Manufacturer;
        $manufacturer->manufacturer = $request->manufacturer;
        $manufacturer->save();

        return redirect('/admin/manufacturers/');
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
     * Display a listing of machines by manufacturer
     * URI: /manufacturers
     * Method: GET
     *
     * @return \Illuminate\Http\Response
     */
    public function showManufacturerIndex()
    {
        // Fetch a list of all the machines grouped by location
        // Use the location field to group the collection by location
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('manufacturer.manufacturer');

        return view('manufacturers.index', [
            'machines' => $machines
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /manufacturers/$id
     * Method: GET
     *
     * @param string $id
     * @return \\Illuminate\Http\Response
     */
    public function showManufacturer($id)
    {
        // Show a list of machines for location $id
        $manufacturer = Manufacturer::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->manufacturer($id)
            ->get();

        return view('manufacturers.manufacturer', [
            'manufacturer' => $manufacturer,
            'machines' => $machines,
            'n' => $machines->count()
        ]);
    }

    /**
     * Show the form for editing a manufacturer
     * URI: /admin/manufacturers/$id/edit
     * Method: GET
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        return view('admin.manufacturers_edit', [
            'manufacturer' => $manufacturer
        ]);
    }

    /**
     * Update the manufacturer.
     * URI: /admin/manufacturers/$id
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'manufacturer' => 'required|string|max:20'
        ]);

        $manufacturer = Manufacturer::find($id);

        $manufacturer->manufacturer = $request->manufacturer;

        $manufacturer->save();

        return redirect('/admin/manufacturers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacturer = Manufacturer::find($id);

        $manufacturer->delete();

        return redirect('/admin/manufacturers');

    }
}
