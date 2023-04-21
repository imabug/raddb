<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyReportRequest;
use App\Models\TestDate;
use Illuminate\Support\Facades\Log;

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
     * Show a form for adding a new survey report.
     *
     * URI: /surveyreports/{id}/create
     *
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View||\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(int $id = null)
    {
        return view('surveys.surveys_addReport');
    }

    /**
     * Handle an uploaded survey report.
     *
     * Form data is validated by App\Http\Requests\StoreSurveyReportRequest
     * User is redirected to the main page after the report is stored.
     *
     * URI: /surveyreports
     *
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreSurveyReportRequest $request)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';
        $status = '';

        // Get the survey data
        $survey = TestDate::find($request->surveyId);

        if ($request->hasFile('surveyReport')) {
            // Associate the photo with the test report (spatie/medialibary)
            // Collection name: survey_reports
            // Filesystem disk: SurveyReports
            // TODO: Check to see if the survey has an existing survey report
            $survey->addMediaFromRequest('surveyReport')
                ->withCustomProperties([
                    'hash' => hash_file('sha512', $request->surveyReport, false),
                ])
                ->toMediaCollection('survey_reports', 'SurveyReports');
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(int $id)
    {
        return TestDate::find($id)->getMedia('survey_reports');
    }
}
