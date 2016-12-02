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
     * Display form for creating a new tube for $machineID
     * URI: /tubes/$machineID/create
     * Method: GET
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
     * Store new tube information in the database
     * URI: /tubes
     * Method: POST
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'machine' => 'required|integer',
            'hsgManufID' => 'integer',
            'hsgModel' => 'string|max:30',
            'hsgSN' => 'string|max:20',
            'insertManufID' => 'integer',
            'insertModel' => 'string|max:30',
            'insertSN' => 'string|max:20',
            'manufDate' => 'date_format:Y-m-d|max:10',
            'installDate' => 'date_format:Y-m-d|max:10',
            'lfs' => 'numeric',
            'mfs' => 'numeric',
            'sfs' => 'numeric',
            'notes' => 'string|max:65535'
        ]);

        $tube = new Tube;
        $tube->machine_id = $request->machine;
        $tube->housing_model = $request->hsgModel;
        $tube->housing_sn = $request->hsgSN;
        $tube->housing_manuf_id = $request->hsgManufID;
        $tube->insert_model = $request->insertModel;
        $tube->insert_sn = $request->insertSN;
        $tube->insert_manuf_id = $request->insertManufID;
        $tube->manuf_date = $request->manufDate;
        $tube->install_date = $request->installDate;
        $tube->lfs = $request->lfs;
        $tube->mfs = $request->mfs;
        $tube->sfs = $request->sfs;
        $tube->notes = $request->notes;
        $tube->tube_status = "Active";

        $tube->save();

        // Tube has been added to the database. Now redirect to the add tube page in case another tube needs to be added
        return view('tubes.tubes_create', [
            'machineID' => $machine->id
        ]);
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
