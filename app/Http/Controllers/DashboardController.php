<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Machine;
use RadDB\TestDate;

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
        /* Get the list of machines that still need to be surveyed
            select machines.id, machines.description from machines
            where machines.machine_status="Active" and machines.id not in
            (select testdates.machine_id from testdates
            where year(testdates.test_date) = $currYear);
        */
        $currSurveys = TestDate::select('machine_id')
            ->year(date('Y'))
            ->get();
        $machinesUntested = Machine::select('id', 'description')
            ->active()
            ->whereNotIn('id', $currSurveys->toArray())
            ->orderBy('description')
            ->get();
        $total = Machine::active()->get()->count();

        /* Get the list of pending surveys
            select testdates.id,machines.description,testdates.test_date,
            testdates.accession, testdates.notes from testdates
            left join machines on testdates.machine_id=machines.id
            where testdates.test_date > CURDATE();
        */
        $pendingSurveys = TestDate::select('testdates.id as surveyId',
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

        /* Get the list of machines and their surveys for this year
         *  and the previous year
         * select machines.id,machines.description,
         * lastyear_view.survey_id as prev_survey_id, lastyear_view.test_date as prev_test_date,
         * thisyear_view.survey_id as curr_survey_id, thisyear_view.test_date as curr_test_date
         * from machines
         * left join thisyear_view on machines.id = thisyear_view.machine_id
         * left join lastyear_view on machines.id = lastyear_view.machine_id
         * where machines.machine_status="Active"
         * order by prev_test_date
         */
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

        return view('index', [
            'machinesUntested' => $machinesUntested,
            'remain'           => $machinesUntested->count(),
            'total'            => $total,
            'pendingSurveys'   => $pendingSurveys,
            'surveySchedule'   => $surveySchedule,
        ]);
    }

    /**
     * Display the count of surveys per month for the specified year.
     *
     * @return \Illuminate\Http\Response
     */
    public function surveycount($yr)
    {
        //
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
