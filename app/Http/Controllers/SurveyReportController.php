<?php

namespace RadDB\Http\Controllers;

use RadDB\TestDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RadDB\Http\Requests\StoreSurveyReportRequest;

class SurveyReportController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only apply auth middleware to these methods
        $this->middleware('auth')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
    }

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
     * Show a form for adding a new survey report.
     * URI: /surveyreports/{id}/create
     * Method: GET.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id = null)
    {
        return view('surveys.surveys_addReport');
    }

    /**
     * Handle an uploaded survey report
     * URI: /surveyreports
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyReportRequest $request)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';

        // Get the survey data
        $survey = TestDate::find($request->surveyId);

        if ($request->hasFile('surveyReport')) {
            // Associate the photo with the test report (spatie/medialibary)
            // Collection name: survey_report
            // Filesystem disk: SurveyReports
            $survey->addMediaFromRequest('surveyReport')
                ->withCustomProperties([
                    'hash'->hash_file('sha512', $request->surveyReport, false),
                ])
                ->toMediaCollection('survey_report', 'SurveyReports');
            $status = 'success';
            $message .= 'Survey report for '.$request->surveyId.' saved.';
            Log::info($message);
        }

        return redirect()
            ->route('index')
            ->with($status, $message);
    }

    /**
     * Display the survey report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return TestDate::find($id)->getMedia('survey_report');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
