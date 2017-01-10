<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RadDB\TestDate;
use RadDB\Recommendation;
use RadDB\Http\Requests;

class RecommendationController extends Controller
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
     * Show the form for adding a new recommendation.
     * URI: /recommendations/$surveyID/create
     * Method: GET
     *
     * @param int $surveyID (optional)
     * @return \Illuminate\Http\Response
     */
    public function create($surveyId = null)
    {
        if (is_null($surveyId)) {
            // No survey id was provided
            $recs = null;
            $machineDesc = null;
        }
        else {
            // Get the machine description corresponding to the survey ID provided
            $machineDesc = TestDate::select('description')
                ->join('machines', 'testdates.machine_id', '=', 'machines.id')
                ->where('testdates.id', $surveyId)
                ->first();

            // Retrieve the recommendations for the provided survey ID
            $recs = Recommendation::surveyID($surveyId)->get();
        }

        return view('recommendations.rec_create', [
            'surveyId' => $surveyId,
            'machineDesc' => $machineDesc,
            'recs' => $recs,
        ]);
    }

    /**
     * Add a new recommendation to the database.
     * URI: /recommendations
     * Method: POST
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'surveyId' => 'required|exists:testdates,id|integer',
            'recommendation' => 'required|string|max:500',
            'resolved' => 'integer',
            'WONum' => 'string|max:20',
            'RecResolveDate' => 'required_with:resolved|date_format:Y-m-d|max:10',
            'ResolvedBy' => 'required_with:resolved|string|max:10',
            'ServiceReport' => 'file|mimes:pdf',
        ]);

        $recommendation = new Recommendation;
        $recommendation->survey_id = $request->surveyId;
        $recommendation->recommendation = $request->recommendation;
        if (isset($request->resolved)) {
            // New recommendation was also marked as resolved
            $recommendation->resolved = 1;
            $recommendation->rec_status = "Complete";
            $recommendation->rec_add_ts = date("Y-m-d H:i:s");
            $recommendation->rec_resolve_ts = date("Y-m-d H:i:s");
            if (isset($request->WONum)) $recommendation->wo_number = $request->WONum;
            if (isset($request->RecResolveDate)) {
                $recommendation->rec_resolve_date = $request->RecResolveDate;
            }
            else {
                $recommendation->rec_resolve_date = date("Y-m-d");
            }
            if (isset($request->ResolvedBy)) $recommendation->resolved_by = $request->ResolvedBy;

            // If a service report was uploaded, handle it
            // This breaks the way service reports were handled in the previous version. Deal with it.

            if ($request->hasFile('ServiceReport')) {
                $serviceReportPath = $request->ServiceReport->store('public/ServiceReports');
                $recommendation->service_report_path = $serviceReportPath;
            }
        }
        else {
            // If the recommendation was not marked as resolved, ignore the rest of the fields
            $recommendation->resolved = 0;
            $recommendation->rec_status = "New";
            $recommendation->rec_add_ts = date("Y-m-d H:i:s");
        }

        $recommendation->save();

        return redirect()->route('recommendations.show', $request->surveyId);

    }

    /**
     * Display the recommendations for a specific survey.
     * URI: /recommendations/$surveyId
     * Method: GET
     *
     * @param int $surveyId
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
            'surveyID' => $surveyId,
            'machineDesc' => $machineDesc,
            'recs' => $recs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the recommendations for $surveyID.
     * URI: /recommendations/$surveyID
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $surveyID)
    {
        $this->validate($request, [
            'recID' => 'array',
            'WONum' => 'string|max:20',
            'RecResolveDate' => 'required|date_format:Y-m-d|max:10',
            'ResolvedBy' => 'string|max:10',
            'ServiceReport' => 'file|mimes:pdf',
        ]);
        $resolved = $request->recID;
        $recResolveDate = $request->RecResolveDate;

        // If a service report was uploaded, handle it
        // This breaks the way service reports were handled in the previous version. Deal with it.

        if ($request->hasFile('ServiceReport')) {
            $serviceReportPath = $request->ServiceReport->store('public/ServiceReports');
            $recommendation->service_report_path = $serviceReportPath;
        }

        foreach ($resolved as $recId) {
            // Retrieve the Recommendations
            $recommendation = Recommendation::findOrFail($recId);

            if (isset($request->WONum)) $recommendation->wo_number = $request->WONum;
            if (isset($request->ResolvedBy)) $recommendation->resolved_by = $request->ResolvedBy;
            if (isset($serviceReportPath)) $recommendation->service_report_path = $serviceReportPath;
            $recommendation->rec_resolve_date = $recResolveDate;
            $recommendation->resolved = 1;
            $recommendation->rec_status = "Complete";
            $recommendation->rec_resolve_ts = date("Y-m-d H:i:s");

            $recommendation->save();
        }

        return redirect()->route('recommendations.show', $surveyID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
