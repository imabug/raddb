<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Modality;
use RadDB\Location;
use RadDB\Manufacturer;
use RadDB\Machine;
use RadDB\Tube;
use RadDB\TestDate;
use RadDB\Http\Requests;

class MachineController extends Controller
{

    /**
     * Display a listing of all active machines.
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
            'machines' => $machines
        ]);
    }

    /**
     * Display a listing of machines grouped by modality
     *
     * @return \Illuminate\Http\Response
     */
    public function showModalityIndex()
    {
        // Fetch a list of all the machines grouped by modality
        // Almost works. Need to figure out how to get the modality description from the top level of the array
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('modality_id');

        return view('machine.list_modalities', [
            'machines' => $machines
        ]);
    }

    /**
     * Display a listing of machines for a specific modality
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function showModality($id)
    {
        // Show a list of machines for modality $id
        $modality = Modality::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality($id)
            ->get();

        return view('machine.list_modality', [
            'modality' => $modality,
            'machines' => $machines,
            'n' => $machines->count()
        ]);
    }

    /**
     * Display a listing of machines by location
     *
     * @return \Illuminate\Http\Response
     */
    public function showLocationIndex()
    {
        // Fetch a list of all the machines grouped by location
        // Almost owrks. Need to figure out how to get th elocation from the top level of the array
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('location_id');

        return view('machine.list_locations', [
            'machines' => $machines
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     *
     * @param string $id
     * @return \\Illuminate\Http\Response
     */
    public function showLocation($id)
    {
        // Show a list of machines for location $id
        $location = Location::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->location($id)
            ->get();

        return view('machine.list_location', [
            'location' => $location,
            'machines' => $machines,
            'n' => $machines->count()
        ]);
    }

    /**
     * Display a listing of survey recommendations for a machine
     *
     * @param int $id
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
     * Retrieve operational notes for a machine
     *
     * @param int $id
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
     * Retrieve generator check data for a machine
     *
     * @param int $id
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
     * Retrieve x-ray tubes for a machine
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
     public function getTubes($id)
     {
         $machineTube = Tube::active()->where([
             [
                 'machine_id',
                 $id
             ]
         ])->get();

         return $machineTube;
     }
    /**
     * Show form for adding a new machine
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
        $locations = Location::select('id','location')
            ->get();

        return view('machine.machines_create', [
            'modalities' => $modalities,
            'manufacturers' => $manufacturers,
            'locations' => $locations
        ]);
    }

    /**
     * Save machine data to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'modality' => 'required|integer',
            'description' => 'required|string|max:60',
            'manufacturer' => 'required|integer',
            'model' => 'required|string|max:20',
            'serialNumber' => 'required|string|max:20',
            'vendSiteID' => 'string|max:25',
            'manufDate' => 'date_format:Y-m-d|max:10',
            'installDate' => 'date_format:Y-m-d|max:10',
            'location' => 'required|integer',
            'room' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive,Removed|max:50',
            'notes' => 'string|max:65535'
        ]);

        $machine = new Machine;
        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        if (isset($machine->vend_site_id)) {
            $machine->vend_site_id = $request->vendSiteID;
        }
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        if (isset($machine->manuf_date)) {
            $machine->manuf_date = $request->manufDate;
        }
        if (isset($machine->install_date)) {
            $machine->install_date = $request->installDate;
        }
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        if (isset($machine->notes)) {
            $machine->notes = $request->notes;
        }

        $machine->save();

        // Machine has been added to the database. Now redirect to the add tube page
        return view('tubes.tubes_create', [
            'machineID' => $machine->id
        ]);
    }

    /**
     * Display the information for machine $id
     *
     * @param string $id
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
            'machine' => $machine,
            'tubes' => $tubes,
            'opnotes' => $opNotes,
            'surveys' => $surveys,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Show the form for editing a machine
     *
     * @param string $id
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
        $locations = Location::select('id','location')
            ->get();

        return view('machine.machines_edit', [
            'modalities' => $modalities,
            'manufacturers' => $manufacturers,
            'locations' => $locations,
            'machine' => $machine
        ]);
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
        $this->validate($request, [
            'modality' => 'required|integer',
            'description' => 'required|string|max:60',
            'manufacturer' => 'required|integer',
            'model' => 'required|string|max:20',
            'serialNumber' => 'required|string|max:20',
            'vendSiteID' => 'string|max:25',
            'manufDate' => 'date_format:Y-m-d|max:10',
            'installDate' => 'date_format:Y-m-d|max:10',
            'location' => 'required|integer',
            'room' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive,Removed|max:50',
            'notes' => 'string|max:65535'
        ]);

        $machine = Machine::find($id);

        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        if (isset($machine->vend_site_id)) {
            $machine->vend_site_id = $request->vendSiteID;
        }
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        if (isset($machine->manuf_date)) {
            $machine->manuf_date = $request->manufDate;
        }
        if (isset($machine->install_date)) {
            $machine->install_date = $request->installDate;
        }
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        if (isset($machine->notes)) {
            $machine->notes = $request->notes;
        }

        $machine->save();

        // Machine has been added to the database. Now redirect to the add tube page
        return redirect('/machines/'.$machine->id);
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
