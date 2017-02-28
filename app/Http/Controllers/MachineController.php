<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\TestDate;
use RadDB\Manufacturer;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\UpdateMachineRequest;

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
        ]);
    }

    /**
     * Return a colelction of survey recommendations for machine $id.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecommendations($id)
    {
        return Machine::findOrFail($id)
            ->recommendation()
            ->get();
    }

    /**
     * Return a collection of operational notes for machine $id.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOperationalNotes($id)
    {
        return Machine::findOrFail($id)
            ->opnote()
            ->get();
    }

     /**
      * Return a collection of generator test data for machine $id.
      *
      * @param int $id
      *
      * @return \Illuminate\Database\Eloquent\Collection
      */
     public function getGenData($id)
     {
         return Machine::findOrFail($id)
            ->gendata()
            ->get();
     }

     /**
      * Return a collection of x-ray tubes for machine $id.
      *
      * @param int $id
      *
      * @return \Illuminate\Database\Eloquent\Collection
      */
     public function getTubes($id)
     {
         return Tube::active()->forMachine($id)->get();
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
        return view('machine.detail', [
            'machine'         => Machine::findOrFail($id),
            'tubes'           => $this->getTubes($id),
            'opnotes'         => $this->getOperationalNotes($id),
            'surveys'         => TestDate::forMachine($id)->orderBy('test_date', 'asc')->get(),
            'recommendations' => $this->getRecommendations($id),
        ]);
    }

    /**
     * Show a list of inactive machines.
     * URI: /machines/inactive
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInactive()
    {
        // Show a list of all the machines in the database
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->inactive()
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Inactive',
            'machines'      => $machines,
        ]);
    }

    /**
     * Show a list of removed machines.
     * URI: /machines/removed
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRemoved()
    {
        // Show a list of all the machines in the database
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->withTrashed()
            ->removed()
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Removed',
            'machines'      => $machines,
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
        $tubes = $this->getTubes($id);

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
