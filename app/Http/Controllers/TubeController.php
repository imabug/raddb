<?php

namespace RadDB\Http\Controllers;

use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\StoreTubeRequest;
use RadDB\Http\Requests\UpdateTubeRequest;
use RadDB\Models\Machine;
use RadDB\Models\Manufacturer;
use RadDB\Models\Tube;

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
            'create',
            'edit',
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
    public function create(int $machineID)
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
    public function store(StoreTubeRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Tube::class);

        $message = '';

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
            $status = 'success';
            $message .= 'New tube saved for machine: '.$tube->machine_id.'.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error adding new tube.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $tube->machine_id)
            ->with($status, $message);
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
    public function edit(int $id)
    {
        // Get the model for the x-ray tube
        $tube = Tube::findOrFail($id);

        // Show the form
        return view('tubes.tubes_edit', [
            'tube'          => $tube,
            'machine'       => $tube->machine,
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
    public function update(UpdateTubeRequest $request, int $id)
    {
        // Check if action is allowed
        $this->authorize(Tube::class);

        $message = '';

        // Retrieve the model for the tube to be edited
        $tube = Tube::findOrFail($id);

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
        $tube->tube_status = $request->tube_status;
        $tube->notes = $request->notes;

        if ($tube->save()) {
            $status = 'success';
            $message .= 'Tube ID '.$tube->id.' for machine '.$tube->machine_id.' updated.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error editing tube.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $request->machine_id)
            ->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // Check if action is allowed
        $this->authorize(Tube::class);

        $message = '';

        // Retrieve the model for the requested tube
        $tube = Tube::findOrFail($id);

        // Update the x-ray tube status
        $tube->remove_date = date('Y-m-d');
        $tube->tube_status = 'Removed';
        $tube->save();

        // Delete and log the x-ray tube removal
        if ($tube->delete()) {
            $status = 'success';
            $message .= 'Tube ID '.$tube->id.' deleted.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error deleting X-ray tube.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $tube->machine_id)
            ->with($status, $message);
    }
}
