<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecommendationRequest;
use App\Http\Requests\UpdateRecommendationRequest;
use App\Models\Recommendation;
use App\Models\TestDate;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only include these methods in the auth middlware
        $this->middleware('auth')->only([
            'create',
            'edit',
            'store',
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
     * Show the form for adding a new recommendation.
     *
     * URI: /recommendations/$surveyId/create
     *
     * Method: GET
     *
     * @param string $surveyId (optional)
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(string $surveyId = null)
    {
        if (is_null($surveyId)) {
            // No survey id was provided.
            $recs = null;
            $serviceReports = null;
            $survey = null;
        } else {
            // Get the machine description corresponding to the survey ID provided
            $survey = TestDate::with('machine')->find((int) $surveyId);
            $serviceReports = $survey->getMedia('service_reports');
            $recs = Recommendation::where('survey_id', (int) $surveyId)->get();
        }

        return view('recommendations.rec_create', [
            'survey'         => $survey,
            'serviceReports' => $serviceReports,
            'recs'           => $recs,
        ]);
    }

    /**
     * Add a new recommendation to the database.
     *
     * Form data is validated in App\Http\Requests\StoreRecommendationRequest
     *
     * URI: /recommendations
     *
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreRecommendationRequest $request, Recommendation $recommendation)
    {
        // Check if action is allowed
        $this->authorize(Recommendation::class);

        $message = '';
        $status = '';

        $survey = TestDate::find($request->surveyId);

        $recommendation->survey_id = $request->surveyId;
        $recommendation->recommendation = $request->recommendation;
        $recommendation->resolved = 0;
        $recommendation->rec_status = 'New';
        $recommendation->rec_add_ts = date('Y-m-d H:i:s');
        // New recommendation was also marked as resolved
        if (isset($request->resolved)) {
            $recommendation->resolved = 1;
            $recommendation->rec_status = 'Complete';
            $recommendation->rec_resolve_ts = date('Y-m-d H:i:s');
            $recommendation->wo_number = $request->WONum;
            $recommendation->rec_resolve_date = $request->has('RecResolveDate') ? $request->RecResolveDate : date('Y-m-d');
            $recommendation->resolved_by = $request->ResolvedBy;

            // If a service report was uploaded, handle it
            if ($request->hasFile('ServiceReport') && $request->file('ServiceReport')->isValid()) {
                // Associate the submitted file with the recommendation (spatie/medialibrary)
                // Collection name: service_reports
                // Filesystem disk: ServiceReports
                $survey->addMediaFromRequest('ServiceReport')
                    ->toMediaCollection('service_reports', 'ServiceReports');
                $message .= "Service report uploaded.\n";
            }
        }

        if ($recommendation->save()) {
            $status = 'success';
            $message .= 'Recommendation '.$recommendation->id.' added.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error adding recommendation.';
            Log::error($message);
        }

        return redirect()
            ->route('recommendations.show', $request->surveyId)
            ->with($status, $message);
    }

    /**
     * Display the recommendations for a specific survey.
     *
     * URI: /recommendations/$surveyId
     *
     * Method: GET.
     *
     * @param string $surveyId
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $surveyId)
    {
        // Get the machine description corresponding to the survey ID provided
        $survey = TestDate::with('machine')->find((int) $surveyId);
        $serviceReports = $survey->getMedia('service_report');

        return view('recommendations.recommendations', [
            'survey'         => $survey,
            'serviceReports' => $serviceReports,
            'recs'           => Recommendation::where('survey_id', (int) $surveyId)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the recommendations for $surveyID.
     *
     * Form data is validated by App\Http\Requests\UpdateRecommendationRequest.
     * User is redirected to the list of recommendations upon completion.
     *
     * URI: /recommendations/$surveyID
     *
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $surveyID
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRecommendationRequest $request, string $surveyID)
    {
        // Check if action is allowed
        $this->authorize(Recommendation::class);

        $message = '';
        $status = '';

        $survey = TestDate::find((int) $surveyID);

        // If a service report was uploaded, handle it
        if ($request->hasFile('ServiceReport') && $request->file('ServiceReport')->isValid()) {
            // Associate the submitted file with the survey (spatie/medialibrary)
            // Collection name: service_reports
            // Filesystem disk: ServiceReports
            $survey->addMediaFromRequest('ServiceReport')
                ->toMediaCollection('service_reports', 'ServiceReports');
            $message .= "Service report uploaded.\n";
        }

        foreach ($request->recID as $recId) {
            // Retrieve the Recommendations
            $recommendation = Recommendation::findOrFail($recId);

            $recommendation->wo_number = $request->has('WONum') ? $request->WONum : null;
            $recommendation->resolved_by = $request->has('ResolvedBy') ? $request->ResolvedBy : null;
            $recommendation->rec_resolve_date = $request->has('RecResolveDate') ? $request->RecResolveDate : date('Y-m-d');
            $recommendation->resolved = 1;
            $recommendation->rec_status = 'Complete';
            $recommendation->rec_resolve_ts = date('Y-m-d H:i:s');

            if ($recommendation->save()) {
                $status = 'success';
                $message .= 'Recommendation '.$recommendation->id.' resolved.';
                Log::info($message);
            } else {
                $status = 'fail';
                $message .= 'Error resolving recommendations.';
                Log::error($message);
            }
        }

        return redirect()
            ->route('recommendations.show', $surveyID)
            ->with($status, $message);
    }
}
