<?php

namespace RadDB\Http\Controllers;

use RadDB\Tester;
use RadDB\Machine;
use Illuminate\Http\Request;

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
    public function showMammoContExp(int $tester_id)
    {
        // TODO
        // Will need to change how this is done to make it more flexible
        $mamMachId = 8;      // Mammography machines
        $mamWrkId = 20;      // Mammography workstations

        // Retrieve tester data
        $tester = Tester::find($tester_id);

        // Get a list of active mammography units
        $mammoMachines = Machine::with('modality', 'manufacturer', 'location', 'testdate')
            ->active()
            ->where('modality_id', $mamMachId)
            ->orderBy('modality_id', 'location_id')
            ->get();

        // Get a list of active mammography workstations
        $mammoWorkstations = Machine::with('modality', 'manufacturer', 'location', 'testdate')
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
