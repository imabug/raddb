<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCalDates()
    {
        return view('testequipment.show_cal_dates');
    }
}
