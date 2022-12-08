<?php

namespace App\Http\Controllers;

use App\Models\Machine;

class TestEquipmentController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only use middlware auth on these methods
        $this->middleware('auth')->only([
            'store',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a list of test equipment with the most recent calibration dates.
     *
     * URI: /testequipment/caldates
     *
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCalDates()
    {
        return view('testequipment.show_cal_dates');
    }
}
