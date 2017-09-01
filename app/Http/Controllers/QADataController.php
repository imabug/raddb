<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\MachineSurveyData;

class QADataController extends Controller
{
    /**
     * Show what survey data exists for the provided survey_id.
     *
     * @param int $survey_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $survey_id)
    {
        $surveyData = MachineSurveyData::with('machine', 'survey')->findOrFail($survey_id);

        return view('qa.survey_data_list', [
            'surveyData' => $surveyData,
        ]);
    }
}
