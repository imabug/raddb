<?php

namespace RadDB\Http\Controllers;

use Carbon\Carbon;
use RadDB\Machine;
use RadDB\TestDate;
use Illuminate\Http\Request;

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
     * Display a listing of test equipment.
     * URI: /testequipment/
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('machine.index', [
            'machines' => Machine::active()->testEquipment()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display a list of test equipment with the most recent calibration dates.
     * URI: /testequipment/caldates
     * Method: GET
     *
     * @return \Illuminate\Http\Response
     */
    public function showCalDates()
    {
        // Fetch a list of all the machines grouped by modality
        $testequipment = Machine::with([
            'manufacturer',
            'location',
            'testdate' => function ($query) {
                $query->where('type_id', '10')->latest('test_date');
            }, ])
            ->active()
            ->testEquipment()
            ->get();

        return view('testequipment.show_cal_dates', [
            'testequipment' => $testequipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
