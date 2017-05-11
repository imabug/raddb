<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Manufacturer;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\ManufacturerRequest;

class ManufacturerController extends Controller
{
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
