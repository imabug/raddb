<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\TestDate;

/*
 * Annual Report Controller.
 *
 * This controller is used to generate summaries of items that might go into an annual
 * report or periodic summary of activities.
 */

class AnnReportController extends Controller
{
    /**
     * Mammography Continued Experience.
     *
     * This method retrieves the last two surveys for each mammography machine
     * and presents it in a table to be used in the Mammography Continued Experience
     * document.
     *
     * URI: /ar/cexp.
     *
     * @todo Take into account who performed the survey (tester_id).
     * @todo Modality ID is hardocded.  Need to make this more flexible.
     *
     * @return \Illuminate\View\View
     */
    public function mammContExp()
    {
        /**
         * @var Illuminate\Database\Eloquent\Collection $mammMachines Collection of active mammography machines.
         **/
        $mammMachines = Machine::with('modality', 'manufacturer', 'location', 'testdate')
            ->active()
            ->modality(8)
            ->get();
        foreach ($mammMachines as $m) {
            // Get the two most recent survey dates
            $recent = $m->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->take(2);
            $mammDates[$m->description] = [
                'location' => $m->location->location,
                'date1'    => $recent->pop()->test_date,
                'date2'    => ($recent->count() == 1) ? $recent->pop()->test_date : '',
            ];
        }

        /**
         * @var Illuminate\Database\Eloquent\Collection $sbbMachines Collection of active SBB machines.
         **/
        $sbbMachines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->modality(15)
            ->get();

        foreach ($sbbMachines as $m) {
            // Get the two most recent survey dates
            $recent = $m->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->take(2);
            $sbbDates[$m->description] = [
                'location' => $m->location->location,
                'date1'    => $recent->pop()->test_date,
                'date2'    => ($recent->count() == 1) ? $recent->pop()->test_date : '',
            ];
        }

        return view('ar.cexp', [
            'mammDates' => $mammDates,
            'sbbDates'  => $sbbDates,
        ]);
    }

    /**
     * Annual report.
     *
     * This method counts up all the surveys and counts all the active machines
     * for the $year provided.  Survey counts are broken down by test type.
     * Equipment inventory counts are provided by modality and by location.
     *
     * URI: /ar/$year/annrep.
     *
     * @param int $year The year to retrieve report data for
     * @return \Illuminate\View\View
     */
    public function annrep(int $year)
    {
        /**
         * @var Illuminate\Database\Eloquent\Collection $surveys Collection of surveys performed during $year.
         **/
        $surveys = TestDate::with('machine', 'type')
            ->year($year)
            ->get();

        $sType = $surveys->groupBy('type.test_type');
        foreach ($sType as $type=>$s) {
            $surveyTypeCount[$type] = $s->count();
        }
        arsort($surveyTypeCount);
        $surveyTotal = $surveys->count();

        /**
         * @var Illuminate\Database\Eloquent\Collection $machines Collection of active machines.
         **/
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
