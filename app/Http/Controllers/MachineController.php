<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateMachineRequest;
use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;

class MachineController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only apply auth middleware to these methods
        $this->middleware('auth')->only([
             'create',
             'edit',
             'store',
             'update',
             'destroy',
         ]);
    }

    /**
     * Display a listing of all active machines.
     * URI: /machines
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of all the machines in the database
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Active',
            'machines'      => $machines,
            'n'             => $machines->count(),
        ]);
    }

    /**
     * Show form for adding a new machine
     * URI: /machines/create
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return data from lookup tables to use in the form
        return view('machine.machines_create', [
            'modalities'    => Modality::get(),
            'manufacturers' => Manufacturer::get(),
            'locations'     => Location::get(),
        ]);
    }

    /**
     * Save machine data to the database
     * URI: /machines
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateMachineRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        $machine = new Machine();
        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        if (isset($request->vendSiteID)) {
            $machine->vend_site_id = $request->vendSiteID;
        }
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        $machine->software_version = $request->softwareVersion;
        if (isset($request->manufDate)) {
            $machine->manuf_date = $request->manufDate;
        }
        if (isset($request->installDate)) {
            $machine->install_date = $request->installDate;
        }
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        $machine->machine_status = $request->status;
        if (isset($request->notes)) {
            $machine->notes = $request->notes;
        }

        if ($machine->save()) {
            $status = 'success';
            $message = 'New machine created: Machine ID '.$machine->id.'.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message = 'Error creating new machine.';
            Log::error($message);
        }

        return redirect()
            ->route('tubes.createTubeFor', $machine->id)
            ->with($status, $message);
    }

    /**
     * Display the information for machine $id
     * URI: /machines/$id
     * Method: GET.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine = Machine::findOrFail($id);
        $machinePhotos = $machine->getMedia('machine_photos');

        return view('machine.detail', [
            'machine'         => $machine,
            'photos'          => $machinePhotos,
            'tubes'           => $machine->tube,
            'opnotes'         => $machine->opnote,
            'surveys'         => $machine->testdate->sortBy('test_date'),
            'recommendations' => $machine->recommendation,
        ]);
    }

    /**
     * Show the form for editing a machine
     * URI: /machines/$id/edit
     * Method: GET.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('machine.machines_edit', [
            'modalities'    => Modality::get(),
            'manufacturers' => Manufacturer::get(),
            'locations'     => Location::get(),
            'machine'       => Machine::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * URI: /machines/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMachineRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        // Retrieve the model for the machine to be edited
        $machine = Machine::find($id);

        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        if (isset($request->vendSiteID)) {
            $machine->vend_site_id = $request->vendSiteID;
        }
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        $machine->software_version = $request->softwareVersion;
        if (isset($request->manufDate)) {
            $machine->manuf_date = $request->manufDate;
        }
        if (isset($request->installDate)) {
            $machine->install_date = $request->installDate;
        }
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        $machine->machine_status = $request->status;
        if (isset($request->notes)) {
            $machine->notes = $request->notes;
        }

        if ($machine->save()) {
            $status = 'success';
            $message = 'Machine ID '.$machine->id.' updated.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message = 'Error editing machine.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $machine->id)
            ->with($status, $message);
    }

    /**
     * Remove machine $id and associated tubes from the database
     * URI: /machines/$id
     * Method: DELETE.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        $machine = Machine::find($id);

        // Retrieve tubes associated with this machine
        $tubes = $machine->tube->where('tube_status', 'Active');

        // Update the status and remove date for the machine
        $machine->machine_status = 'Removed';
        $machine->remove_date = date('Y-m-d');
        $machine->save();

        // Set the delete status for each tube
        foreach ($tubes as $tube) {
            $tube->tube_status = 'Removed';
            $tube->remove_date = date('Y-m-d');
            $tube->save();
            if ($tube->delete()) {
                $message .= 'Tube ID '.$tube->id.' deleted.';
            } else {
                $message .= 'Error deleting tube ID '.$tube->id.'.';
            }
        }

        if ($machine->delete()) {
            $status = 'success';
            $message .= 'Machine ID '.$machine->id.' deleted.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error deleting machine ID '.$machine->id.'.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.index')
            ->with($status, $message);
    }
}
