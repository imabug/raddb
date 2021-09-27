<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\Manufacturer;
use RadDB\TestDate;
use RadDB\TestType;
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
        $testTypes = TestType::get();
        $locations = Location::get();
        $modalities = Modality::get();
        $surveys = TestDate::with('machine', 'type')
            -> year($year)
            -> get();
        $machines = Machine::active()
            ->get();

        foreach ($testTypes as $t) {
            $c = $surveys->where('type_id', $t->id)->count();
            if ($c > 0) $surveyTypeCount[$t->test_type] = $c;
        }
        arsort($surveyTypeCount);
        $surveyTypeCount["Total"] = $surveys->count();

        foreach ($modalities as $m) {
            $c = $machines->where('modality_id', $m->id)->count();
            if ($c > 0) $modalitiesCount[$m->modality] = $c;
        }
        arsort($modalitiesCount);

        foreach($locations as $l) {
            $c = $machines->where('location_id', $l->id)->count();
            if ($c > 0) $locationsCount[$l->location] = $c;
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
