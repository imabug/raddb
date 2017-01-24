<?php

namespace RadDB\Http\Controllers;

use DB;
use Charts;
use Carbon\Carbon;
use RadDB\Machine;
use RadDB\TestDate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Main index page.
     * Display list of machines that need to be surveyed, pending
     * surveys and the survey schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the list of machines that still need to be surveyed
        $machinesUntested = $this->untested();
        $total = Machine::active()->get()->count();

        // Get the list of pending surveys
        $pendingSurveys = $this->pending();

        // Get the list of machines and their surveys for this year and the previous year
        $surveySchedule = $this->surveySchedule();

        return view('index', [
            'machinesUntested' => $machinesUntested,
            'remain'           => $machinesUntested->count(),
            'total'            => $total,
            'pendingSurveys'   => $pendingSurveys,
            'surveySchedule'   => $surveySchedule,
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
    public function untested()
    {
        /* Get the list of machines that still need to be surveyed
            select machines.id, machines.description from machines
            where machines.machine_status="Active" and machines.id not in
            (select testdates.machine_id from testdates
            where year(testdates.test_date) = $currYear);
        */
        $currSurveys = TestDate::select('machine_id')
            ->year(date('Y'))
            ->get();
        $untested = Machine::select('id', 'description')
            ->active()
            ->whereNotIn('id', $currSurveys->toArray())
            ->orderBy('description')
            ->get();

        return $untested;
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
    public function pending()
    {
        /* Get the list of pending surveys
            select testdates.id,machines.description,testdates.test_date,
            testdates.accession, testdates.notes from testdates
            left join machines on testdates.machine_id=machines.id
            where testdates.test_date > CURDATE();
        */
        $pending = TestDate::select('testdates.id as surveyId',
                'machines.id as machineId',
                'machines.description',
                'testdates.test_date',
                'testdates.accession',
                'testdates.notes')
            ->leftJoin('machines',
                'testdates.machine_id', '=', 'machines.id')
            ->pending()
            ->orderBy('testdates.test_date', 'asc')
            ->get();

        return $pending;
    }

    /**
     * Get the list of machines and their surveys for this year and the previous year
     * select machines.id,machines.description,
     * lastyear_view.survey_id as prev_survey_id, lastyear_view.test_date as prev_test_date,
     * thisyear_view.survey_id as curr_survey_id, thisyear_view.test_date as curr_test_date
     * from machines
     * left join thisyear_view on machines.id = thisyear_view.machine_id
     * left join lastyear_view on machines.id = lastyear_view.machine_id
     * where machines.machine_status="Active"
     * order by prev_test_date.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function surveySchedule()
    {
        // Get the list of machines and their surveys for this year
        // TODO: may not handle machines with multiple surveys in a year very well
        $surveySchedule = Machine::select('machines.id',
                'machines.description',
                'lastyear_view.survey_id as prevSurveyID',
                'lastyear_view.test_date as prevSurveyDate',
                'lastyear_view.report_file_path as prevSurveyReport',
                'thisyear_view.survey_id as currSurveyID',
                'thisyear_view.test_date as currSurveyDate',
                'thisyear_view.report_file_path as currSurveyReport')
            ->active()
            ->leftJoin('thisyear_view', 'machines.id', '=', 'thisyear_view.machine_id')
            ->leftJoin('lastyear_view', 'machines.id', '=', 'lastyear_view.machine_id')
            ->orderBy('lastyear_view.test_date', 'asc')
            ->get();

        return $surveySchedule;
    }

    /**
     * Display a bar chart showing the count of surveys per month for the specified year.
     * Uses the ConsoleTVs/Charts package from https://erik.cat/projects/Charts.
     *
     * @return \Illuminate\Http\Response
     */
    public function surveyGraph(Request $request)
    {
        if (isset($request->yr)) {
            $yr = $request->yr;
        } else {
            $yr = Carbon::now()->year;
        }

        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years')
            ->get();
        $yearChart = Charts::database(TestDate::year($yr)->get(), 'bar', 'google')
            ->dateColumn('test_date')
            ->title('Monthly survey count for '.$yr)
            ->elementLabel('Number of surveys')
            ->dimensions(1000, 700)
            ->groupByMonth($yr, true);
        $allYears = Charts::database(TestDate::get(), 'bar', 'google')
            ->dateColumn('test_date')
            ->title('Survey count for all years')
            ->elementLabel('Number of surveys')
            ->dimensions(1000, 700)
            ->groupByYear($years->count());

        return view('dashboard.survey_graph', [
            'yearChart' => $yearChart,
            'allYears' => $allYears,
            'years' => $years,
        ]);
    }

    /**
     * Equipment test status dashboard
     * Each machine is displayed in a table showing machine description,
     * survey date and colour coded based on test status. Machines are
     * grouped by modality.
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

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show grid of untested machines.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUntested()
    {
        // Get the list of machines that still need to be surveyed
        $machinesUntested = $this->untested();
        $total = Machine::active()->get()->count();

        return view('dashboard.untested', [
            'machinesUntested' => $machinesUntested,
            'remain'           => $machinesUntested->count(),
            'total'            => $total,
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showPending()
    {
        // Get the list of pending surveys
        $pendingSurveys = $this->pending();

        return view('dashboard.pending', [
            'pendingSurveys'   => $pendingSurveys,
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showSchedule()
    {
        // Get the list of machines and their surveys for this year and the previous year
        $surveySchedule = $this->surveySchedule();

        return view('dashboard.survey_schedule', [
            'surveySchedule'   => $surveySchedule,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
