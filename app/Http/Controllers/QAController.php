<?php

namespace RadDB\Http\Controllers;

use Charts;
use RadDB\Machine;
use RadDB\TestDates;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\RadSurveyData;
use RadDB\RadiationOutput;
use Illuminate\Http\Request;

class QAController extends Controller
{
    /**
     * Index page for QA/survey data section
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a table of machines with QA data in the database
        // Get a list of the survey IDs in the gendata table
        $surveys = GenData::select('survey_id')->distinct()->get();
        $machines = TestDate::whereIn('id', $surveys->toArray())->get();
        
        return view('qa.index', [
            
        ]);
    }
}
