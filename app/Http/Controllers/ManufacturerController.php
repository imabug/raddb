<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Manufacturer;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\ManufacturerRequest;

class ManufacturerController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         // Exclude these methods from the auth middlware
         $this->middleware('auth')->except([
             'showManufacturer',
             'showManufacturerIndex',
         ]);
     }

    /**
     * Show a list of the manufacturers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.manufacturers_index', [
            'manufacturers' => Manufacturer::get(),
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
     * URI: /admin/manufacturers
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ManufacturerRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Manufacturer::class);

        $manufacturer = new Manufacturer();
        $manufacturer->manufacturer = $request->manufacturer;
        if ($manufacturer->save()) {
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
        return view('admin.manufacturers_edit', [
            'manufacturer' => Manufacturer::findOrFail($id),
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
    public function update(ManufacturerRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(Manufacturer::class);

        $manufacturer = Manufacturer::find($id);

        $manufacturer->manufacturer = $request->manufacturer;

        if ($manufacturer->save()) {
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
        // Check if action is allowed
        $this->authorize(Manufacturer::class);

        $manufacturer = Manufacturer::find($id);

        if ($manufacturer->delete()) {
            $message = 'Manufacturer '.$manufacturer->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('manufacturers.index');
    }
}
