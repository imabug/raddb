<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\SurveyScheduleView;
use App\Models\TestDate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}
