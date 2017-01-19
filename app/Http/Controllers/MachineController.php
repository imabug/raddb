<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
// use RadDB\Http\Requests\UpdateMachineRequest;
use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\TestDate;
use RadDB\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachineController extends Controller
{
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
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of survey recommendations for a machine.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecommendations($id)
    {
        $machineRecommendations = Machine::findOrFail($id)
            ->recommendation()
            ->get();

        return $machineRecommendations;
    }

    /**
     * Retrieve operational notes for a machine.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOperationalNotes($id)
    {
        $machineOpNotes = Machine::findOrFail($id)
            ->opnote()
            ->get();

        return $machineOpNotes;
    }

     /**
      * Retrieve generator check data for a machine.
      *
      * @param int $id
      *
      * @return \Illuminate\Database\Eloquent\Collection
      */
     public function getGenData($id)
     {
         $machineGenData = Machine::findOrFail($id)
            ->gendata()
            ->get();

         return $machineGenData;
     }

     /**
      * Retrieve x-ray tubes for a machine.
      *
      * @param int $id
      *
      * @return \Illuminate\Database\Eloquent\Collection
      */
     public function getTubes($id)
     {
         $machineTube = Tube::active()->where([
             [
                 'machine_id',
                 $id,
             ],
         ])->get();

         return $machineTube;
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
        // Get the list of modalities
        $modalities = Modality::select('id', 'modality')
            ->get();
        // Get the list of manufacturers
        $manufacturers = Manufacturer::select('id', 'manufacturer')
            ->get();
        // Get the list of locations
        $locations = Location::select('id', 'location')
            ->get();

        return view('machine.machines_create', [
            'modalities'    => $modalities,
            'manufacturers' => $manufacturers,
            'locations'     => $locations,
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'modality'     => 'required|integer',
            'description'  => 'required|string|max:60',
            'manufacturer' => 'required|integer',
            'model'        => 'required|string|max:20',
            'serialNumber' => 'required|string|max:20',
            'vendSiteID'   => 'string|max:25',
            'manufDate'    => 'date_format:Y-m-d|max:10',
            'installDate'  => 'date_format:Y-m-d|max:10',
            'location'     => 'required|integer',
            'room'         => 'required|string|max:20',
            'status'       => 'required|in:Active,Inactive,Removed|max:50',
            'notes'        => 'string|max:65535',
        ]);

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

        $saved = $machine->save();
        if ($saved) {
            $message = 'New machine created: Machine ID '.$machine->id;
            Log::info($message);

            return redirect()->route('tubes.createTubeFor', $machine->id)
                ->with('success', 'New machine created');
        } else {
            return redirect()->route('tubes.createTubeFor', $machine->id)
                ->with('fail', 'Error creating new machine');
        }
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
        // Retrieve details for a specific machine
        $machine = Machine::findOrFail($id); // application will return HTTP 404 if $id doesn't exist

        // Retrieve the active tubes for machine $id
        $tubes = $this->getTubes($id);

        // Retrieve the surveys for machine $id
        $surveys = TestDate::where('machine_id', $id)->orderBy('test_date', 'asc')->get();

        // Retrieve the operational notes for machine $id
        $opNotes = $this->getOperationalNotes($id);

        // Retrieve the survey recommendations for machine $id
        $recommendations = $this->getRecommendations($id);

        return view('machine.detail', [
            'machine'         => $machine,
            'tubes'           => $tubes,
            'opnotes'         => $opNotes,
            'surveys'         => $surveys,
            'recommendations' => $recommendations,
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
        // Get information for the machine to edit
        $machine = Machine::findOrFail($id);

        // Get the list of modalities
        $modalities = Modality::select('id', 'modality')
            ->get();
        // Get the list of manufacturers
        $manufacturers = Manufacturer::select('id', 'manufacturer')
            ->get();
        // Get the list of locations
        $locations = Location::select('id', 'location')
            ->get();

        return view('machine.machines_edit', [
            'modalities'    => $modalities,
            'manufacturers' => $manufacturers,
            'locations'     => $locations,
            'machine'       => $machine,
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'modality_id'     => 'required|integer',
            'description'     => 'required|string|max:60',
            'manufacturer_id' => 'required|integer',
            'model'           => 'required|string|max:20',
            'serialNumber'    => 'required|string|max:20',
            'vendSiteID'      => 'string|max:25',
            'manufDate'       => 'date_format:Y-m-d|max:10',
            'installDate'     => 'date_format:Y-m-d|max:10',
            'location_id'     => 'required|integer',
            'room'            => 'required|string|max:20',
            'status'          => 'required|in:Active,Inactive,Removed|max:50',
            'notes'           => 'string|max:65535',
        ]);

        // Retrieve the model for the machine to be edited
        $machine = Machine::find($id);

        $machine->modality_id = $request->modality_id;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer_id;
        if (isset($request->vendSiteID)) {
            $machine->vend_site_id = $request->vendSiteID;
        }
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        if (isset($request->manuf_date)) {
            $machine->manuf_date = $request->manufDate;
        }
        if (isset($request->install_date)) {
            $machine->install_date = $request->installDate;
        }
        $machine->location_id = $request->location_id;
        $machine->room = $request->room;
        $machine->machine_status = $request->status;
        if (isset($request->notes)) {
            $machine->notes = $request->notes;
        }

        $saved = $machine->save();
        if ($saved) {
            $message = 'Machine ID '.$machine->id.' updated.';
            Log::info($message);

            return redirect()->route('machines.show', $machine->id)
                ->with('success', 'Machine edited');
        } else {
            return redirect()->route('machines.show', $machine->id)
                ->with('fail', 'Error editing machine');
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
            $tube->delete();
        }

        $deleted = $machine->delete();
        if ($deleted) {
            $message = 'Machine ID '.$machine->id.' deleted.';
            Log::notice($message);

            return redirect()->route('machines.index')
                ->with('success', 'Machine deleted');
        } else {
            return redirect()->route('machines.index')
                ->with('fail', 'Error deleting machine');
        }

    }
}
