<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\Manufacturer;
use RadDB\TestDate;
use Illuminate\Http\Request;

class AnnReportController extends Controller
{
    /**
     * Show a summary of the estimated effort for testing all active machines
     * URI: /ar/effort
     */
    public function effort()
    {
        // Get the list of all active machines
        $machines = Machine::with('modality', 'manufacturer', 'location', 'tube')
                  ->active()->get()->groupBy('modality.modality');

        foreach ($machines as $key=>$modality) {
            $n[$key] = count($modality);
            $tubes[$key] = 0;
            foreach ($modality as $machine) {
                echo $machine->description." "." ".$key." ".$machine->tube()->active()->count()."\n";
                if ($machine->tube()->active()->count() == 0) {
                    // If there are no tubes recorded in the DB, assume the machine has one tube
                    $tubes[$key]++;
                }
                else {
                    $tubes[$key] += $machine->tube()->active()->count();
                }
                echo $key." ".$tubes[$key]."\n";
            }
        }
        return view('ar.effort', [
            'n' => $n,
            'tubes' => $tubes,
        ]);
    }

    /**
     * Generate a mammography continued experience report
     * URI: /ar/mamcexp
     */
    public function mammContExp()
    {
        // Get a list of the mammo machines
        $machines = Machine::with('manufacturer', 'location', 'testdate')->active()->modality(8)->get()->groupBy('location.location');
    }
}
