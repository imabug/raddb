<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManufacturerController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         $this->middleware('auth')->except([
             'showManufacturer',
             'showManufacturerIndex',
         ]);
     }

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
            'manufacturers' => $manufacturers,
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
     * Add a new manufacturer to the database.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'manufacturer' => 'required|string|max:20',
        ]);

        $manufacturer = new Manufacturer();
        $manufacturer->manufacturer = $request->manufacturer;
        $saved = $manufacturer->save();
        if ($saved) {
            $message = 'Manufacturer '.$manufacturer->manufacturer.' added.';
            Log::info($message);
        }

        return redirect()->route('manufacturers.index');
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
     * Display a listing of machines by manufacturer
     * URI: /manufacturers
     * Method: GET.
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
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /manufacturers/$id
     * Method: GET.
     *
     * @param string $id
     *
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
        $manufacturer = Manufacturer::findOrFail($id);

        return view('admin.manufacturers_edit', [
            'manufacturer' => $manufacturer,
        ]);
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'manufacturer' => 'required|string|max:20',
        ]);

        $manufacturer = Manufacturer::find($id);

        $manufacturer->manufacturer = $request->manufacturer;

        $saved = $manufacturer->save();
        if ($saved) {
            $message = 'Manufacturer '.$manufacturer->id.' edited.';
            Log::info($message);
        }

        return redirect()->route('manufacturers.index');
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
        $manufacturer = Manufacturer::find($id);

        $deleted = $manufacturer->delete();
        if ($deleted) {
            $message = 'Manufacturer '.$manufacturer->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('manufacturers.index');
    }
}
