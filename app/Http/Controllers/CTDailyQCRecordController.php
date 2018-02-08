<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\CTDailyQCRecord;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\CTDailyQCRecordRequest;

class CTDailyQCRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new CT daily QC record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ctdailyqc.ctdailyqcrecord_create', [
            'ct_scanners' => Machine::with('location', 'manufacturer')
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
        dd($request);
        $ctQcRec = CTDailyQCRecord::create([
            'machine_id'    => $request->machine_id,
            'qcdate'        => $request->qcdate,
            'scan_type'     => $request->scan_type,
            'water_hu'      => $request->water_hu,
            'water_sd'      => $request->water_sd,
            'artifacts'     => $request->artifacts,
            'notes'         => $request->notes,
        ]);

        if (is_null($ctQcRec)) {
            $status = 'fail';
            $message = 'Unable to add QC record.';
        } else {
            $status = 'success';
            $message = 'QC record added.';
        }

        return redirect()
            ->route('ctdailyqcrecord.create')
            ->with($status, $message);
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
