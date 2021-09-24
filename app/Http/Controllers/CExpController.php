<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Location;
use RadDB\Machine;
use RadDB\Manufacturer;
use RadDB\Modality;

class CExpController extends Controller
{
    /**
     * Get a list of the two most recent annual surveys for each active mammography unit
     * for the MQSA Continued Experience list
     *
     */
    public function cexp() {
        // Get a list of active mammography machines
        $mammMachines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality(8)
            ->get();
        $sbbMachines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality(15)
            ->get();

        return view('ar.cexp', [
            'mammMachines' => $mammMachines,
            'sbbMachines' => $sbbMachines,
        ]);
    }

}
