<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Manufacturer;
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
