<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Machine;
use RadDB\Tube;
use RadDB\Manufacturer;
use RadDB\Http\Requests;

class TubeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display form for creating a new tube for $machienID
     *
     * @param int $machineID
     * @return \Illuminate\Http\Response
     */
    public function create($machineID)
    {
        // Get the list of machines
        $machines = Machine::select('id','description')
            ->get();
        // Get the list of manufacturers
        $manufacturers = Manufacturer::select('id', 'manufacturer')
            ->get();

        return view('tubes.tubes_create', [
            'machines' => $machines,
            'manufacturers' => $manufacturers,
            'machineID' => $machineID
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
