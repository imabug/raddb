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
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $surveys = TestDate::year(date('Y'))
            ->where(function ($query) {
                $query->whereNull('report_file_path')
                    ->orWhere('report_file_path', '');
            })
            ->get();

        return view('surveys.surveys_addReport', [
            'surveys' => $surveys,
        ]);
    }

    /**
     * Handle an uploaded survey report
     * URI: /surveyreports
     * Method: PUT.
     *
     * @param int                      $surveyId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyReportRequest $request)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';

        // Get the path to store the survey report
        $path = env('SURVEY_REPORT_PATH', 'public/SurveyReports');

        // Get the survey data
        $survey = TestDate::find($request->surveyId);

        // Get the year of the survey
        $testDate = date_parse($survey->test_date);
        $year = $testDate['year'];

        // Append the year to the survey report path
        $path = $path.'/'.$year;

        // Handle the uploaded file
        // This breaks the way service reports were handled in the previous version.
        if ($request->hasFile('surveyReport')) {
            $survey->report_file_path = $request->surveyReport->store($path);
        }

        if ($survey->save()) {
            $status = 'success';
            $message .= 'Survey report for survey '.$survey->id.' stored.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error uploading survey report.';
            Log::error($message);
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
    public function show($id)
    {
        $survey = TestDate::findOrFail($id);
        if (Storage::exists($survey->report_file_path)) {
            return redirect(Storage::url($survey->report_file_path));
        } else {
            return redirect()->route('machines.show', $id);
        }
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
