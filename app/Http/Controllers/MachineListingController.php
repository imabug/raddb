<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachineListingController extends Controller
{
    // This controller handles showing various machine listings

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
     * Show a list of machines installed by year
     * URI: /machines/installed/$yr
     * Method: GET.
     *
     * @param int $year
     *
     * @return \Illuminate\Http\Response
     */
    public function showInstalled(int $year = null)
    {
        if (is_null($year)) {
            $year = date('y');
        }
    }

    /**
     * Display a listing of machines by location
     * URI: /locations
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLocationIndex()
    {
        // Fetch a list of all the machines grouped by location
        // Use the location field to group the collection by location
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('location.location');

        return view('machine.locations.index', [
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /locations/$id
     * Method: GET.
     *
     * @param string $id
     *
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

        return view('machine.locations.location', [
            'location' => $location,
            'machines' => $machines,
            'n'        => $machines->count(),
        ]);
    }

    /**
     * Display a listing of machines by manufacturer
     * URI: /manufacturers
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showManufacturerIndex()
    {
        // Fetch a list of all the machines grouped by location
        // Use the location field to group the collection by location
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('manufacturer.manufacturer');

        return view('machine.manufacturers.index', [
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific location
     * URI: /manufacturers/$id
     * Method: GET.
     *
     * @param string $id
     *
     * @return \\Illuminate\Http\Response
     */
    public function showManufacturer($id)
    {
        // Show a list of machines for location $id
        $manufacturer = Manufacturer::findOrFail($id); // application will return HTTP 404 if $id doesn't exist
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->manufacturer($id)
            ->get();

        return view('machine.manufacturers.manufacturer', [
            'manufacturer' => $manufacturer,
            'machines'     => $machines,
            'n'            => $machines->count(),
        ]);
    }

    /**
     * Display a listing of machines grouped by modality
     * URI: /modalities
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showModalityIndex()
    {
        // Fetch a list of all the machines grouped by modality
        // Use the modality field to group the collection by modality
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->get()
            ->groupBy('modality.modality');

        return view('machine.modalities.index', [
            'machines' => $machines,
        ]);
    }

    /**
     * Display a listing of machines for a specific modality
     * URI: /modalities/$id
     * Method: GET.
     *
     * @param string $id
     *
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

        return view('machine.modalities.modality', [
            'modality' => $modality,
            'machines' => $machines,
            'n'        => $machines->count(),
        ]);
    }
}
