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
     * URI: /ar/annrep.
     *
     * @param int $year
     */
    public function annrep(int $year)
    {
        // Get all the surveys performed in $year
        $surveys = TestDate::with('machine', 'type')
            ->year($year)
            ->get()
            ->groupBy('type.test_type');

        $total = 0;
        foreach ($surveys as $type=>$s) {
            $surveyTypeCount[$type] = $s->count();
            $total += $s->count();
        }
        arsort($surveyTypeCount);
        $surveyTypeCount['Total surveys'] = $total;

        // Get all the active machines grouped by modality
        $machines = Machine::with('modality')
            ->active()
            ->get()
            ->groupBy('modality.modality');

        $total = 0;
        foreach ($machines as $modality=>$m) {
            $modalitiesCount[$modality] = $m->count();
            $total += $m->count();
        }
        arsort($modalitiesCount);
        $modalitiesCount['Total machines'] = $total;

        // Get all the active machines grouped by location
        $machines = Machine::with('modality')
            ->active()
            ->get()
            ->groupBy('location.location');

        foreach ($machines as $location=>$m) {
            $locationsCount[$location] = $m->count();
        }
        arsort($locationsCount);

        return view('ar.annrep', [
            'year'            => $year,
            'surveyTypeCount' => collect($surveyTypeCount),
            'modalitiesCount' => collect($modalitiesCount),
            'locationsCount'  => collect($locationsCount),
        ]);
    }
}