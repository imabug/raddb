<?php

namespace RadDB\Http\Controllers;

use RadDB\GenData;
use RadDB\HVLData;
use RadDB\Machine;
use RadDB\FluoroData;
use RadDB\MaxFluoroData;
use RadDB\RadSurveyData;
use RadDB\CollimatorData;
use RadDB\RadiationOutput;
use Illuminate\Http\Request;
use RadDB\MachineSurveyData;
use RadDB\ReceptorEntranceExp;

class QAController extends Controller
{
    /**
     * Index page for QA/survey data section.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a table of machines with QA data in the database.

        // Get a list of machines with survey data
        $machWithSurveyData = MachineSurveyData::select('machine_id')->distinct()->get();

        // Get only the active machines
        $machines = Machine::whereIn('id', $machWithSurveyData->toArray())->active()->get();

        return view('qa.index', [
            'machines' => $machines,
        ]);
    }

    /**
     * Show the survey test data available for a machine.
     *
     * @param int $machine_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $machine_id)
    {
        $machine = Machine::findOrFail($machine_id);
        $surveyData = MachineSurveyData::with('survey')->where('machine_id', $machine_id)->get();

        return view('qa.survey_list', [
            'machine' => $machine,
            'surveyData' => $surveyData,
        ]);
    }
}
