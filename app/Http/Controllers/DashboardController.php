<?php

namespace RadDB\Http\Controllers;

use DB;
use Charts;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\SurveyScheduleView;
use Illuminate\Http\Request;

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
            'pendingSurveys'   => $this->pending(),
            'surveySchedule'   => $this->surveySchedule(),
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
     * Get the list of machines and their surveys for this year and the previous year
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function surveySchedule()
    {
        // Get the list of machines and their surveys for this year
        // TODO: may not handle machines with multiple surveys in a year very well

        return SurveyScheduleView::get();
    }

    /**
     * Display a bar chart showing the count of surveys per month for the specified year.
     * Uses the ConsoleTVs/Charts package from https://erik.cat/projects/Charts.
     * URI: /dashboard/surveyGraph
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function surveyGraph()
    {
        // Get a list of all the years there are surveys for
        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();
        // Create a bar chart for each year
        foreach ($years as $y) {
            $yearCharts[$y->years] = Charts::database(TestDate::year($y->years)->get(), 'bar', 'google')
                ->dateColumn('test_date')
                ->title('Monthly survey count for '.$y->years)
                ->elementLabel('Number of surveys')
                ->dimensions(1000, 700)
                ->monthFormat('M Y')
                ->groupByMonth($y->years, true);
        }
        // Create a bar chart showing total number of surveys done in each year
        $allYears = Charts::database(TestDate::get(), 'bar', 'google')
            ->dateColumn('test_date')
            ->title('Survey count for all years')
            ->elementLabel('Number of surveys')
            ->dimensions(1000, 700)
            ->groupByYear($years->count());

        return view('dashboard.survey_graph', [
            'yearCharts' => $yearCharts,
            'allYears' => $allYears,
        ]);
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
     * Show grid of untested machines.
     * URI: /dashboard/showUntested
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUntested()
    {
        return view('dashboard.untested', [
            'machinesUntested' => $this->untested(),
            'remain'           => $this->untested()->count(),
            'total'            => Machine::active()->get()->count(),
        ]);
    }

    /**
     * Show the list of pending surveys
     * URI: /dashboard/showPending
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPending()
    {
        return view('dashboard.pending', [
            'pendingSurveys'   => $this->pending(),
        ]);
    }

    /**
     * Show the survey schedule for the year
     * URI: /dashboard/showSchedule
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSchedule()
    {
        // Get the list of machines and their surveys for this year and the previous year
        return view('dashboard.survey_schedule', [
            'surveySchedule'   => $this->surveySchedule(),
        ]);
    }
}
