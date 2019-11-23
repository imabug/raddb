<?php

namespace RadDB\Http\Controllers;

use Charts;
use Illuminate\Support\Facades\Log;
use RadDB\CTDailyQCRecord;
use RadDB\Http\Requests\CTDailyQCRecordRequest;
use RadDB\Machine;

class CTDailyQCRecordController extends Controller
{
    /**
     * Display a listing of CT scanners that the user will select from to
     * show QC data for.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ctdailyqc.ctdailyqcrecord_index', [
            'ctScanners' => Machine::with('location', 'manufacturer')
                            ->modality(7)->active()->get(),
        ]);
    }

    /**
     * Show the form for creating a new CT daily QC record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ctdailyqc.ctdailyqcrecord_create', [
            'ctScanners' => Machine::with('location', 'manufacturer')
                            ->modality(7)->active()->get(),
        ]);
    }

    /**
     * Store a CT daily QC record.
     *
     * @param  \RadDB\Http\Requests\CTDailyQCRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CTDailyQCRecordRequest $request)
    {
        $message = '';
        $status = '';

        // Store axial QC record
        $ctQcRec = CTDailyQCRecord::create([
            'machine_id'    => $request->machine_id,
            'qcdate'        => $request->qcdate,
            'scan_type'     => $request->scan_type[0],
            'water_hu'      => $request->water_hu[0],
            'water_sd'      => $request->water_sd[0],
            'artifacts'     => $request->artifacts[0],
            'initials'      => $request->initials,
            'notes'         => $request->notes,
        ]);

        // Store helical QC record
        $ctQcRec = CTDailyQCRecord::create([
            'machine_id'    => $request->machine_id,
            'qcdate'        => $request->qcdate,
            'scan_type'     => $request->scan_type[1],
            'water_hu'      => $request->water_hu[1],
            'water_sd'      => $request->water_sd[1],
            'artifacts'     => $request->artifacts[1],
            'initials'      => $request->initials,
            'notes'         => $request->notes,
        ]);

        if (is_null($ctQcRec)) {
            $status = 'fail';
            $message = 'Unable to add QC record.';
            Log::error($message);
        } else {
            $status = 'success';
            $message = 'QC record added.';
            Log::info($message);
        }

        return redirect()
            ->route('ctdailyqc.show', ['id' => $request->machine_id])
            ->with($status, $message);
    }

    /**
     * Display the daily QC records for the selected CT scanner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ctScanner = Machine::find($id);
        $ctQcRecords = CTDailyQCRecord::where('machine_id', $id)
            ->with('machine')
            ->orderBy('qcdate', 'desc')
            ->get();

        return view('ctdailyqc.ctdailyqcrecord_show', [
            'ctScanner' => $ctScanner,
            'ctQcRecords' => $ctQcRecords,
            'numRecords' => $ctQcRecords->count(),
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
     * @param  \RadDB\Http\Requests\CTDailyQCRecordRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CTDailyQCRecordRequest $request, $id)
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
