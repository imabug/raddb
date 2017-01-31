<?php

namespace RadDB\Http\Controllers;

use RadDB\TestDate;
use RadDB\Recommendation;
// use Illuminate\Http\Request;
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
            // No survey id was provided
            $recs = null;
            $machineDesc = null;
        } else {
            // Get the machine description corresponding to the survey ID provided
            $machineDesc = TestDate::select('description')
                ->join('machines', 'testdates.machine_id', '=', 'machines.id')
                ->where('testdates.id', $surveyId)
                ->first();

            // Retrieve the recommendations for the provided survey ID
            $recs = Recommendation::surveyID($surveyId)->get();
        }

        return view('recommendations.rec_create', [
            'surveyId'    => $surveyId,
            'machineDesc' => $machineDesc,
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
                $recommendation->rec_resolve_date = date('Y-m-d');
            } else {
                $recommendation->rec_resolve_date = $request->RecResolveDate;
            }
            $recommendation->resolved_by = $request->ResolvedBy;

            // If a service report was uploaded, handle it
            // This breaks the way service reports were handled in the previous version. Deal with it.
            if ($request->hasFile('ServiceReport')) {
                $recommendation->service_report_path = $request->ServiceReport->store('public/ServiceReports');
            }
        } else {
            // If the recommendation was not marked as resolved, ignore the rest of the fields
            $recommendation->resolved = 0;
            $recommendation->rec_status = 'New';
            $recommendation->rec_add_ts = date('Y-m-d H:i:s');
        }

        if ($recommendation->save()) {
            $message = 'Recommendation '.$recommendation->id.' added.';
            Log::info($message);

            return redirect()->route('recommendations.show', $request->surveyId)
                ->with('success', 'Service report uploaded');
        } else {
            return redirect()->route('recommendations.show', $request->surveyId)
                ->with('fail', 'Error uploading service report');
        }
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
        $machineDesc = TestDate::select('description')
            ->join('machines', 'testdates.machine_id', '=', 'machines.id')
            ->where('testdates.id', $surveyId)
            ->first();

        // Get the recommendations
        $recs = Recommendation::surveyId($surveyId)->get();

        return view('recommendations.recommendations', [
            'surveyID'    => $surveyId,
            'machineDesc' => $machineDesc,
            'recs'        => $recs,
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

        $resolved = $request->recID;
        $recResolveDate = $request->RecResolveDate;

        foreach ($resolved as $recId) {
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

            // If a service report was uploaded, handle it
            // This breaks the way service reports were handled in the previous version. Deal with it.
            if ($request->hasFile('ServiceReport')) {
                $serviceReportPath = $request->ServiceReport->store('public/ServiceReports');
                $recommendation->service_report_path = $serviceReportPath;
            }

            if ($recommendation->save()) {
                $message = 'Recommendation '.$recommendation->id.' edited.';
                Log::info($message);
            }
        }

        return redirect()->route('recommendations.show', $surveyID);
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
