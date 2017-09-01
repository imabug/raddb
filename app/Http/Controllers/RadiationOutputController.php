<?php

namespace RadDB\Http\Controllers;

use Charts;
use RadDB\TestDate;
use RadDB\RadiationOutput;
use Illuminate\Http\Request;

class RadiationOutputController extends Controller
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
     * @param int $surveyId
     * @return \Illuminate\Http\Response
     */
    public function show(int $surveyId)
    {
        $survey = TestDate::with('machine')->findOrFail($surveyId);
        $radOutput = RadiationOutput::where('survey_id', $surveyId)->orderBy('kv')->get();
        $radOutputChart = Charts::create('scatter', 'google')
                        ->labels($radOutput->pluck('kv'))
                        ->values($radOutput->pluck('output'))
                        ->elementLabel('Output')
                        ->title('Radiation Output')
                        ->xAxisTitle('kV')
                        ->yAxisTitle('mGy/mAs @ 40 in.')
                        ->responsive(false)
                        ->height(600)
                        ->width(800)
                        ->legend(true);

        return view('qa.radoutput.show', [
            'survey' => $survey,
            'radOutput' => $radOutput,
            'radOutputChart' => $radOutputChart,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \RadDB\RadiationOutput  $radiationOutput
     * @return \Illuminate\Http\Response
     */
    public function edit(RadiationOutput $radiationOutput)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \RadDB\RadiationOutput  $radiationOutput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RadiationOutput $radiationOutput)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \RadDB\RadiationOutput  $radiationOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(RadiationOutput $radiationOutput)
    {
        //
    }
}
