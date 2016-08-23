<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Modality;
use RadDB\Location;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return view('machine.detail', [
            'machine' => $machine,
            'tubes' => $tubes,
            'opnotes' => $opNotes,
            'surveys' => $surveys
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
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
