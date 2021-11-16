<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\SurveyScheduleView;
use App\Models\TestDate;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;

class DashboardController extends Controller
{
    /**
     * Main index page.
     * Display list of machines that need to be surveyed, pending
     * surveys and the survey schedule.
     * URI: /
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [
            'machinesUntested' => $this->untested(),
            'remain'           => $this->untested()->count(),
            'total'            => Machine::active()->get()->count(),
            // 'pendingSurveys'   => $this->pending(),
            // 'surveySchedule'   => $this->surveySchedule(),
        ]);
    }

    /**
     * Get the list of machines that still need to be surveyed
     * select machines.id, machines.description from machines
     * where machines.machine_status="Active" and machines.id not in
     * (select testdates.machine_id from testdates
     * where year(testdates.test_date) = $currYear);.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function untested()
    {
        // Collection of machines that have already been tested
        $currSurveys = TestDate::select('machine_id')
            ->year(date('Y'))
            ->get();
        // Untested machines are the ones that aren't in the above list
        return Machine::select('id', 'description')
            ->active()
            ->whereNotIn('id', $currSurveys->toArray())
            ->orderBy('description')
            ->get();
    }

    /**
     * Get the list of pending surveys
     * select testdates.id,machines.description,testdates.test_date,
     * testdates.accession, testdates.notes from testdates
     * left join machines on testdates.machine_id=machines.id
     * where testdates.test_date > CURDATE();.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function pending()
    {
        return TestDate::with('machine', 'type')
            ->pending()
            ->orderBy('testdates.test_date', 'asc')
            ->get();
    }

    /**
     * Get the list of machines and their surveys for this year and the previous year.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function surveySchedule()
    {
        // Get the list of machines and their surveys for this year
        // TODO: may not handle machines with multiple surveys in a year very well

        return SurveyScheduleView::with('machine', 'prevSurvey', 'currSurvey')
            ->get();
    }

    /**
     * Equipment test status dashboard
     * Each machine is displayed in a table showing machine description,
     * survey date and colour coded based on test status. Machines are
     * grouped by modality.
     * URI: /dashboard
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function teststatus()
    {
        // Fetch a list of all the machines grouped by modality
        $machines = Machine::with([
            'modality',
            'location',
            'testdate' => function ($query) {
                $query->where('type_id', '1')->orWhere('type_id', '2')->latest('test_date');
            }, ])
            ->active()
            ->get()
            ->groupBy('modality.modality');

        return view('dashboard.test_status', [
            'machines' => $machines,
        ]);
    }

    /**
     * Show graphs of survey counts using Lavacharts
     */
    public function showSurveyCounts()
    {
        //
        $months = [1 => "Jan", 2 => "Feb", 3 => "Mar",
                   4 => "Apr", 5 => "May", 6 => "Jun",
                   7 => "Jul", 8 => "Aug", 9 => "Sep",
                   10 => "Oct", 11 => "Nov", 12 => "Dec"];

        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();

        foreach ($years as $y) {
            // Initialize temp array used to hold survey counts by month
            foreach ($months as $m) {
                $c[] = [$m, 0];
            }

            $chartData = DB::select('select month(test_date) as m, count(*) as c from testdates where year(test_date)=:y group by month(test_date)', [$y->years]);

            // DB::select returns an array where each array element is a PHP stdClass object with the query result.
            // Convert this to an array with plain numeric elements.
            foreach ($chartData as $cd) {
                // Replace the count data for the month in the $c array
                $c[($cd->m)-1] = [$months[$cd->m], $cd->c];
            }

            // Set up the data table for the chart
            $surveyCounts = \Lava::DataTable()
                ->addStringColumn("Month")
                ->addNumberColumn("Num Surveys")
                ->addRows($c);

            // Create a column chart
            \Lava::ColumnChart('Survey count - '.$y->years,
                               $surveyCounts,
                               [
                                   'title' => 'Survey counts - '.$y->years,
                                   'titleTextStyle' => [
                                       'fontSize' => 14],
                               ]);

            // Clear variables for the next loop iteration
            unset($c);
            unset($surveyCounts);
        }

        unset($y);

        // Get a count of all surveys except for these test type_id's
        // 8 - Other
        // 10 - Calibration
        $yearCounts = TestDate::whereNotIn('type_id', [8, 10])
            ->get()
            ->countBy(function ($item, $key) {
                return substr($item['test_date'], 0, 4);
            })
            ->sortKeys()
            ->toArray();

        // $yearCounts is an associative array.  Need a 2D array
        // to pass to \Lava::DataTable()
        foreach ($yearCounts as $yr => $count) {
            $y[] = [(string) $yr, $count];
        }

        $yearlySurveyCounts = \Lava::DataTable()
            ->addStringColumn('Year')
            ->addNumberColumn('Num Surveys')
            ->addRows($y);

        \Lava::ColumnChart('Yearly Survey Count',
                          $yearlySurveyCounts,
                          [
                              'title' => 'Yearly survey counts',
                              'titleTextStyle' => [
                                  'fontSize' => 14],
                          ]);

        return view('dashboard.survey_counts', [
            'years' => $years,
        ]);
    }
}
