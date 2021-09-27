<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
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
            ->active()
            ->get()
            ->groupBy('modality.modality');

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

    /**
     * Present data that will be used in the annual report
     * URI: /ar/annrep
     *
     * @param int $year
     */
    public function annrep(int $year)
    {
        // Get all the surveys performed in $year
        $surveys = TestDate::with('machine', 'type')
            -> year($year)
            -> get()
            -> groupBy('type.test_type');

        $total = 0;
        foreach ($surveys as $type=>$s) {
            $surveyTypeCount[$type] = $s->count();
            $total += $s->count();
        }
        arsort($surveyTypeCount);
        $surveyTypeCount["Total surveys"] = $total;

        // Get all the active machines grouped by modality
        $machines = Machine::with('modality')
            -> active()
            -> get()
            -> groupBy('modality.modality');

        $total = 0;
        foreach ($machines as $modality=>$m) {
            $modalitiesCount[$modality] = $m->count();
            $total += $m->count();
        }
        arsort($modalitiesCount);
        $modalitiesCount["Total machines"] = $total;

        // Get all the active machines grouped by location
        $machines = Machine::with('modality')
            -> active()
            -> get()
            -> groupBy('location.location');

        foreach($machines as $location=>$m) {
            $locationsCount[$location] = $m->count();
        }
        arsort($locationsCount);

        return view('ar.annrep', [
            'year' => $year,
            'surveyTypeCount' => $surveyTypeCount,
            'modalitiesCount' => $modalitiesCount,
            'locationsCount' => $locationsCount,
        ]);
    }
}
