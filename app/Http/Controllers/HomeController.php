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
        // $this->middleware('auth');
    }

    /**
     * Main index page.
     *
     * The survey schedule is a table of all the active machines with their previous
     * and current survey dates and survey IDs.  Provided by a Laravel Livewire
     * Tables ({@link https://rappasoft.com/packages/laravel-livewire-tables}) component,
     * \App\Http\Livewire\SurveyScheduleTable.
     * The Pending survey view displays a table of pending surveys (scheduled but not
     * performed yet).  Provided by a Laravel Livewire Tables component,
     * \App\Http\Livewire\PendingSurveysTable
     * Untested displays a table of machines that have not been tested yet for the year.
     *
     * URI: /
     *
     * Method: GET.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index', [
            'machinesUntested' => $this->untested(),
            'remain'           => $this->untested()->count(),
            'total'            => Machine::active()->get()->count(),
        ]);
    }

    /**
     * Get a list of active machines that still need to be surveyed.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function untested()
    {
        // Collection of machines that have already been tested
        $currSurveys = TestDate::select('machine_id')
            ->year(date('Y'))
            ->get();

        // Select the active machines that aren't in $currSurveys
        return Machine::select('id', 'description')
            ->active()
            ->whereNotIn('id', $currSurveys->toArray())
            ->orderBy('description')
            ->get();
    }
}
