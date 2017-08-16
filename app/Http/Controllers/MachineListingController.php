<?php

namespace RadDB\Http\Controllers;

use RadDB\Tester;
use RadDB\Machine;
use RadDB\TestDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MachineListingController extends Controller
{
    // This controller handles showing various machine listings

    /**
     * Show a list of inactive machines.
     * URI: /machines/inactive
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInactive()
    {
        // Show a list of all the machines in the database
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->inactive()
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Inactive',
            'machines'      => $machines,
        ]);
    }

    /**
     * Show a list of removed machines.
     * URI: /machines/removed
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRemoved(int $year = null)
    {
        if (is_null($year)) {
            // If no year was specified, use the current year.
            $year = date('Y');
        }

        // Show a list of all the machines in the database
        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->withTrashed()
            ->removed()
            ->where(DB::raw('YEAR(remove_date)'), $year)
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Removed '.$year,
            'machines'      => $machines,
        ]);
    }

    /**
     * Show a list of machines installed by year
     * URI: /machines/installed/$yr
     * Method: GET.
     *
     * @param int $year
     *
     * @return \Illuminate\Http\Response
     */
    public function showInstalled(int $year = null)
    {
        if (is_null($year)) {
            // If no year was specified, use the current year.
            $year = date('Y');
        }

        $machines = Machine::with('modality', 'manufacturer', 'location')
            ->active()
            ->where(DB::raw('YEAR(install_date)'), $year)
            ->get();

        return view('machine.index', [
            'machineStatus' => 'Installed '.$year,
            'machines'      => $machines,
        ]);
    }
}
