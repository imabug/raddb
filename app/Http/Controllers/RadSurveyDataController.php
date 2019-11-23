<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\RadSurveyData;
use RadDB\TestDate;

class RadSurveyDataController extends Controller
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
        $radSurveyData = RadSurveyData::with('machine', 'survey')->where('survey_id', $surveyId)->first();

        return view('qa.radsurvey.show', [
            'radSurveyData' => $radSurveyData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \RadDB\RadSurveyData  $radSurveyData
     * @return \Illuminate\Http\Response
     */
    public function edit(RadSurveyData $radSurveyData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \RadDB\RadSurveyData  $radSurveyData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RadSurveyData $radSurveyData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \RadDB\RadSurveyData  $radSurveyData
     * @return \Illuminate\Http\Response
     */
    public function destroy(RadSurveyData $radSurveyData)
    {
        //
    }
}
