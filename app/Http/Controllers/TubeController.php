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
         // Only use auth middlware on these methods
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
        return view('tubes.tubes_create', [
            'machines'      => Machine::get(),
            'manufacturers' => Manufacturer::get(),
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
        $tube->machine_id = $request->machine_id;
        $tube->housing_model = $request->hsgModel;
        $tube->housing_sn = $request->hsgSN;
        $tube->housing_manuf_id = $request->hsgManufID;
        $tube->insert_model = $request->insertModel;
        $tube->insert_sn = $request->insertSN;
        $tube->insert_manuf_id = $request->insertManufID;
        $tube->manuf_date = $request->manufDate;
        $tube->install_date = $request->installDate;
        if (empty($request->lfs)) {
            $tube->lfs = 0.0;
        } else {
            $tube->lfs = $request->lfs;
        }
        if (empty($request->mfs)) {
            $tube->mfs = 0.0;
        } else {
            $tube->mfs = $request->mfs;
        }
        if (empty($request->sfs)) {
            $tube->sfs = 0.0;
        } else {
            $tube->sfs = $request->sfs;
        }
        $tube->notes = $request->notes;
        $tube->tube_status = 'Active';

        if ($tube->save()) {
            $message = 'New tube saved for machine: '.$tube->machine_id.'.';
            Log::info($message);

            return redirect()->route('machines.show', $tube->machine_id)
                ->with('success', 'New tube added');
        } else {
            return redirect()->route('machines.show', $tube->machine_id)
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
        // Get the model for the x-ray tube
        $tube = Tube::findOrFail($id);

        // Get the information for the corresponding machine
        $machine = Machine::select('id', 'description')
            ->where('id', '=', $tube->machine_id)
            ->first();

        // Show the form
        return view('tubes.tubes_edit', [
            'tube'          => $tube,
            'machine'       => $machine,
            'manufacturers' => Manufacturer::get(),
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

        // Retrieve the model for the tube to be edited
        $tube = Tube::find($id);

        $tube->machine_id = $request->machine_id;
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

        if ($tube->save()) {
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
        // Check if action is allowed
        $this->authorize(Tube::class);

        // Retrieve the model for the requested tube
        $tube = Tube::find($id);

        // Update the x-ray tube status
        $tube->remove_date = date('Y-m-d');
        $tube->tube_status = 'Removed';
        $tube->save();

        // Delete and log the x-ray tube removal
        if ($tube->delete()) {
            $message = 'Tube ID '.$tube->id.' deleted.';
            Log::notice($message);

            return redirect()->route('machines.show', $tube->machine_id)
                ->with('success', 'X-ray tube deleted');
        } else {
            return redirect()->route('machines.show', $tube->machine_id)
                ->with('fail', 'Error deleting X-ray tube');
        }
    }
}
