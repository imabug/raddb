<?php

namespace RadDB\Http\Controllers;

use RadDB\TestDate;
use RadDB\Recommendation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RadDB\Http\Requests\StoreRecommendationRequest;
use RadDB\Http\Requests\UpdateRecommendationRequest;

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
     * URI: /recommendations/$surveyID/create
     * Method: GET.
     *
     * @param int $surveyID (optional)
     *
     * @return \Illuminate\Http\Response
     */
    public function create($surveyId = null)
    {
        if (is_null($surveyId)) {
            // No survey id was provided.
            $recs = null;
            $machine = null;
        } else {
            // Get the machine description corresponding to the survey ID provided
            $machine = TestDate::select('testdates.machine_id as machine_id', 'machines.description as description')
                ->join('machines', 'testdates.machine_id', '=', 'machines.id')
                ->where('testdates.id', $surveyId)
                ->first();
            $recs = Recommendation::where('survey_id', $surveyId)->get();
        }

        return view('recommendations.rec_create', [
            'surveyId'    => $surveyId,
            'machine'     => $machine,
            'recs'        => $recs,
        ]);
    }

    /**
     * Add a new recommendation to the database.
     * URI: /recommendations
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecommendationRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Recommendation::class);

        $message = '';
        // Get the path service reports are stored in.
        // Default to public/ServiceReports if the environment variable isn't set
        $path = env('SERVICE_REPORT_PATH', 'public/ServiceReports');

        $recommendation = new Recommendation();
        $recommendation->survey_id = $request->surveyId;
        $recommendation->recommendation = $request->recommendation;
        if (isset($request->resolved)) {
            // New recommendation was also marked as resolved
            $recommendation->resolved = 1;
            $recommendation->rec_status = 'Complete';
            $recommendation->rec_add_ts = date('Y-m-d H:i:s');
            $recommendation->rec_resolve_ts = date('Y-m-d H:i:s');
            $recommendation->wo_number = $request->WONum;
            if (is_null($request->RecResolveDate)) {
                // Recommendation resolved date wasn't set (should have been).
                // Use current date as a default.
                $recommendation->rec_resolve_date = date('Y-m-d');
            } else {
                $recommendation->rec_resolve_date = $request->RecResolveDate;
            }
            $recommendation->resolved_by = $request->ResolvedBy;

            // If a service report was uploaded, handle it
            // This breaks the way service reports were handled in the previous version. Deal with it.
            if ($request->hasFile('ServiceReport')) {
                // Get the test date corresponding to the recommendation
                $recYear = date_parse($recommendation->survey->test_date);
                // Tack on the year of the survey to the storage path
                $path .= '/'.$recYear['year'];
                $recommendation->service_report_path = $request->ServiceReport->store($path);
                $message .= 'Service report uploaded to '.$recommendation->service_report_path.'\n';
            }
        } else {
            // If the recommendation was not marked as resolved, ignore the rest of the fields
            $recommendation->resolved = 0;
            $recommendation->rec_status = 'New';
            $recommendation->rec_add_ts = date('Y-m-d H:i:s');
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
     * URI: /recommendations/$surveyId
     * Method: GET.
     *
     * @param int $surveyId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($surveyId)
    {
        // Get the machine description corresponding to the survey ID provided
        $machine = TestDate::select('testdates.machine_id as machine_id', 'machines.description as description')
            ->join('machines', 'testdates.machine_id', '=', 'machines.id')
            ->where('testdates.id', $surveyId)
            ->first();

        return view('recommendations.recommendations', [
            'surveyID'    => $surveyId,
            'machine'     => $machine,
            'recs'        => Recommendation::where('survey_id', $surveyId)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the recommendations for $surveyID.
     * URI: /recommendations/$surveyID
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecommendationRequest $request, $surveyID)
    {
        // Check if action is allowed
        $this->authorize(Recommendation::class);

        $message = '';
        $path = env('SERVICE_REPORT_PATH', 'public/ServiceReports');

        $recResolveDate = $request->RecResolveDate;

        // If a service report was uploaded, handle it
        // This breaks the way service reports were handled in the previous version. Deal with it.
        if ($request->hasFile('ServiceReport')) {
            // Get the test date for the associated survey
            $testDate = date_parse(TestDate::find($surveyID)->test_date);
            // Tack on the year of the survey to the storage path
            $path .= '/'.$testDate['year'];
            $serviceReportPath = $request->ServiceReport->store($path);
            $message .= "Service report uploaded.\n";
        } else {
            $serviceReportPath = null;
        }

        foreach ($request->recID as $recId) {
            // Retrieve the Recommendations
            $recommendation = Recommendation::findOrFail($recId);

            if (isset($request->WONum)) {
                $recommendation->wo_number = $request->WONum;
            }
            if (isset($request->ResolvedBy)) {
                $recommendation->resolved_by = $request->ResolvedBy;
            }
            $recommendation->rec_resolve_date = $recResolveDate;
            $recommendation->resolved = 1;
            $recommendation->rec_status = 'Complete';
            $recommendation->rec_resolve_ts = date('Y-m-d H:i:s');
            $recommendation->service_report_path = $serviceReportPath;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
