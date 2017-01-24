<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
use RadDB\Machine;
use RadDB\Manufacturer;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\UpdateTubeRequest;

class TubeController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         $this->middleware('auth')->only([
             'store',
             'update',
             'destroy',
         ]);
     }

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
     * Method: GET.
     *
     * @param int $machineID
     *
     * @return \Illuminate\Http\Response
     */
    public function create($machineID)
    {
        // Get the list of machines
        $machines = Machine::select('id', 'description')
            ->get();
        // Get the list of manufacturers
        $manufacturers = Manufacturer::select('id', 'manufacturer')
            ->get();

        return view('tubes.tubes_create', [
            'machines'      => $machines,
            'manufacturers' => $manufacturers,
            'machineID'     => $machineID,
        ]);
    }

    /**
     * Store new tube information in the database
     * URI: /tubes
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateTubeRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Tube::class);

        $tube = new Tube();
        $tube->machine_id = $request->machine;
        $tube->housing_model = $request->hsgModel;
        $tube->housing_sn = $request->hsgSN;
        $tube->housing_manuf_id = $request->hsgManufID;
        $tube->insert_model = $request->insertModel;
        $tube->insert_sn = $request->insertSN;
        $tube->insert_manuf_id = $request->insertManufID;
        $tube->manuf_date = $request->manufDate;
        $tube->install_date = $request->installDate;
        if (! empty($request->lfs)) {
            $tube->lfs = $request->lfs;
        } else {
            $tube->lfs = 0.0;
        }
        if (! empty($request->mfs)) {
            $tube->mfs = $request->mfs;
        } else {
            $tube->mfs = 0.0;
        }
        if (! empty($request->sfs)) {
            $tube->sfs = $request->sfs;
        } else {
            $tube->sfs = 0.0;
        }
        $tube->notes = $request->notes;
        $tube->tube_status = 'Active';

        $saved = $tube->save();
        if ($saved) {
            $message = 'New tube saved for machine: '.$tube->machine_id.'.';
            Log::info($message);

            return redirect()->route('tubes.createTubeFor', $request->machine)
                ->with('success', 'New tube added');
        } else {
            return redirect()->route('tubes.createTubeFor', $request->machine)
                ->with('fail', 'Error adding new tube');
        }
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
     * Show the form for editing a tube.
     * URI: /tubes/$id/edit
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the information for the tube to edit
        $tube = Tube::findOrFail($id);

        // Get the information for the corresponding machine
        $machine = Machine::select('id', 'description')
            ->where('id', '=', $tube->machine_id)
            ->first();

        // Get the list of manufacturers
        $manufacturers = Manufacturer::select('id', 'manufacturer')->get();

        // Show the form
        return view('tubes.tubes_edit', [
            'tube'          => $tube,
            'machine'       => $machine,
            'manufacturers' => $manufacturers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * URI: /tubes/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTubeRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(Tube::class);

        // Retrieve the model for the t ube to be edited
        $tube = Tube::find($id);

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

        $saved = $tube->save();
        if ($saved) {
            $message = 'Tube ID '.$tube->id.' for machine '.$tube->machine_id.' updated.';
            Log::info($message);

            return redirect()->route('machines.show', $request->machine_id)
                ->with('success', 'Tube edited');
        } else {
            return redirect()->route('machines.show', $request->machine_id)
                ->with('fail', 'Error editing tube');
        }
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
        //
    }
}
