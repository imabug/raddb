<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\TestDate;

class AnnReportController extends Controller
{
    /**
     * Generate a mammography continued experience report
     * URI: /ar/mamcexp.
     */
    public function mammContExp()
    {
        // Get a list of the mammo machines
        // Get a list of active mammography machines
        $mammMachines = Machine::with('modality', 'manufacturer', 'location', 'testdate')
            ->active()
            ->modality(8)
            ->get();
        foreach ($mammMachines as $m) {
            // Get the two most recent survey dates
            $recent = $m->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->take(2);
            if ($recent->count() < 2) {
                $mammDates[$m->description] = [
                    'location' => $m->location->location,
                    'date1'    => $recent->pop()->test_date,
                    'date2'    => '',
                ];
            } else {
                $mammDates[$m->description] = [
                    'location' => $m->location->location,
                    'date1'    => $recent->pop()->test_date,
                    'date2'    => $recent->pop()->test_date,
                ];
            }
        }

        $sbbMachines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality(15)
            ->get();

        foreach ($sbbMachines as $m) {
            // Get the two most recent survey dates
            $recent = $m->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->take(2);
            if ($recent->count() < 2) {
                $sbbDates[$m->description] = [
                    'location' => $m->location->location,
                    'date1'    => $recent->pop()->test_date,
                    'date2'    => '',
                ];
            } else {
                $sbbDates[$m->description] = [
                    'location' => $m->location->location,
                    'date1'    => $recent->pop()->test_date,
                    'date2'    => $recent->pop()->test_date,
                ];
            }
        }

        return view('ar.cexp', [
            'mammDates' => $mammDates,
            'sbbDates'  => $sbbDates,
        ]);
    }

    /**
     * Present data that will be used in the annual report
     * URI: /ar/$year/annrep.
     *
     * @param int $year
     */
    public function annrep(int $year)
    {
        // Get all the surveys performed in $year
        $surveys = TestDate::with('machine', 'type')
            ->year($year)
            ->get();

        $sType = $surveys->groupBy('type.test_type');
        foreach ($sType as $type=>$s) {
            $surveyTypeCount[$type] = $s->count();
        }
        arsort($surveyTypeCount);
        $surveyTotal = $surveys->count();

        // Get all the active machines
        $machines = Machine::with('modality', 'location')
            ->active()
            ->get();

        // Group by modality and count them up
        $mod = $machines->groupBy('modality.modality');
        foreach ($mod as $modality=>$m) {
            $modalitiesCount[$modality] = $m->count();
        }
        arsort($modalitiesCount);
        $machineTotal = $machines->count();

        // Group by location and count them up
        $loc = $machines->groupBy('location.location');
        foreach ($loc as $location=>$m) {
            $locationsCount[$location] = $m->count();
        }
        arsort($locationsCount);

        return view('ar.annrep', [
            'year'            => $year,
            'surveyTotal'     => $surveyTotal,
            'machineTotal'    => $machineTotal,
            'surveyTypeCount' => collect($surveyTypeCount),
            'modalitiesCount' => collect($modalitiesCount),
            'locationsCount'  => collect($locationsCount),
        ]);
    }
}
