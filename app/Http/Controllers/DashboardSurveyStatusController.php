<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\View\View;

class DashboardSurveyStatusController extends Controller
{
    /**
     * Equipment test status dashboard.
     *
     * Each machine is displayed in a table showing machine description,
     * location, and survey date.  The survey date is colour coded based on test status.
     * Green - Current.  Machine has been tested within the past year.
     * Cyan -  Survey is due within 30 days
     * Yellow - Survey is overdue but less than 13 months overdue.
     * Red - Survey is overdue by more than 13 months.
     * Blue - Survey is scheduled.
     * Machines are grouped by modality.
     *
     * URI: /dashboard
     *
     * Method: GET
     */
    public function teststatus(): View
    {
        // Fetch a list of all active machines grouped by modality
        // Include test dates where the test type is 1 (Routine Compliance) or
        // 2 (Acceptance)
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
}
