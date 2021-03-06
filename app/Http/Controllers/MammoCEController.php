<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Machine;
use RadDB\Tester;

class MammoCEController extends Controller
{
    /**
     * Display a listing of recently surveyed mammography units to satisfy
     * MQSA continuing experience requirement
     * URI: /machines/mcexp
     * Method: GET.
     *
     * @param  int $tester_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $tester_id)
    {
        // TODO
        // Will need to change how this is done to make it more flexible
        $mamMachId = 8;      // Mammography machines
        $mamWrkId = 20;      // Mammography workstations

        // Retrieve tester data
        $tester = Tester::find($tester_id);

        // Get a list of active mammography units tested by $tester
        $mammoMachines = Machine::with(['modality', 'manufacturer', 'location',
            'testdate' => function ($query) use ($tester) {
                $query->where('tester1_id', $tester->id)
                      ->orWhere('tester2_id', $tester->id);
            }, ])
            ->active()
            ->where('modality_id', $mamMachId)
            ->orderBy('modality_id', 'location_id', 'description')
            ->get();

        // Get a list of active mammography workstations tested by $tester
        $mammoWorkstations = Machine::with(['modality', 'manufacturer', 'location',
            'testdate' => function ($query) use ($tester) {
                $query->where('tester1_id', $tester->id)
                      ->orWhere('tester2_id', $tester->id);
            }, ])
            ->active()
            ->where('modality_id', $mamWrkId)
            ->orderBy('modality_id', 'location_id', 'description')
            ->get();

        return view('mammo.mammCE', [
            'tester' => $tester,
            'reportDate' => date('Y-M-d'),
            'mammoMachines' => $mammoMachines,
            'mammoWorkstations' => $mammoWorkstations,
        ]);
    }
}
