<?php

namespace RadDB\Http\Controllers;

use Charts;
use RadDB\HVLData;
use RadDB\TestDate;
use Illuminate\Http\Request;

class HVLDataController extends Controller
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
     * @param  int $surveyId
     * @return \Illuminate\Http\Response
     */
    public function show(int $surveyId)
    {
        $survey = TestDate::with('machine')->findOrFail($surveyId);
        $hvl = HVLData::where('survey_id', $surveyId)->orderBy('kv')->get();
        $hvlChart = Charts::create('scatter', 'google')
                  ->labels($hvl->pluck('kv'))
                  ->values($hvl->pluck('hvl'))
                  ->elementLabel('HVL')
                  ->title('Half value layer')
                  ->xAxisTitle('kV')
                  ->yAxistitle('mm Al')
                  ->responsive(false)
                  ->height(600)
                  ->width(800)
                  ->legend(true);

        return view('qa.hvl.show', [
            'survey' => $survey,
            'hvl' => $hvl,
            'hvlChart' => $hvlChart,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \RadDB\HVLData  $hVLData
     * @return \Illuminate\Http\Response
     */
    public function edit(HVLData $hVLData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \RadDB\HVLData  $hVLData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HVLData $hVLData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \RadDB\HVLData  $hVLData
     * @return \Illuminate\Http\Response
     */
    public function destroy(HVLData $hVLData)
    {
        //
    }
}
