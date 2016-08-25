<?php
namespace RadDB\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\Http\Requests;

class DashboardController extends Controller
{

    /**
     * Main index page.
     * Display list of machines that need to be surveyed, pending
     * surveys and the survey schedule
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Get the list of machines that still need to be surveyed
            select machines.id, machines.description from machines
            where machines.machine_status="Active" and machines.id not in
            (select testdates.machine_id from testdates
            where year(testdates.test_date) = "2016");
        */
        $currSurveys = TestDate::select('machine_id')
            ->year(date("Y"))
            ->get();
        $machinesUntested = Machine::select('id', 'description')
            ->active()
            ->whereNotIn('id', $currSurveys->toArray())
            ->get();
        $total = Machine::active()->get()->count();

        /* Get the list of pending surveys
            select testdates.id,machines.description,testdates.test_date,
            testdates.accession, testdates.notes from testdates
            left join machines on testdates.machine_id=machines.id
            where testdates.test_date > CURDATE();
        */
        $pendingSurveys = TestDate::select('testdates.id',
                'machines.description',
                'testdates.test_date',
                'testdates.accession',
                'testdates.notes')
            ->leftJoin('machines',
                'testdates.machine_id', '=', 'machines.id')
            ->where('testdates.test_date', '>=', date("Y-m-d"))
            ->orderBy('testdates.test_date','asc')
            ->get();

        /* Get the list of machines and their surveys for this year
           and the previous year
           select machines.id, machines.description, previous.id as prevSurveyID,
           previous.test_date as prevSurveyDate, current.id as currSurveyID,
           current.test_date as currSurveyDate from machines
           left join testdates as previous on (machines.id=previous.machine_id)
           join testdates as current using (machine_id)
           where year(previous.test_date)='2015'
           and year(current.test_date)='2016'
           order by previous.test_date asc;
        */
        // TODO: query misses machines with no survey in previous year
        // TODO: may not handle machines with multiple surveys in a year very well
        $surveySchedule = Machine::select('machines.id',
                'machines.description',
                'previous.id as prevSurveyID',
                'previous.test_date as prevSurveyDate',
                'previous.report_file_path as prevSurveyReport',
                'current.id as currSurveyID',
                'current.test_date as currSurveyDate',
                'current.report_file_path as currSurveyReport')
            ->active()
            ->leftJoin('testdates as previous',
                'machines.id', '=', 'previous.machine_id')
            ->join('testdates as current',
                'current.machine_id', '=', 'previous.machine_id')
            ->whereYear('previous.test_date', '=', date("Y")-1)
            ->whereYear('current.test_date', '=', date("Y"))
            ->orderBy('previous.test_date', 'asc')
            ->get();

        return view('index', [
            'machinesUntested' => $machinesUntested,
            'remain' => $machinesUntested->count(),
            'total' => $total,
            'pendingSurveys' => $pendingSurveys,
            'surveySchedule' => $surveySchedule
        ]);

    }

    /*
     * Display the count of surveys per month for the specified year
     *
     * @param $yr
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function surveycount($yr)
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
     * @param int $id
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
