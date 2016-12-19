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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        return view('surveys.recommendations', [
            'surveyID' => $surveyId,
            'machineDesc' => $machineDesc,
            'recs' => $recs
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
        // Service reports are stored in the storage/app/public/ServiceReports/$recResolveYr
        $path = "ServiceReports/" . date_parse($recResolveDate)['year'];
        if (!is_dir($path)) {
            Storage::makeDirectory($path);
        }

        if ($request->hasFile('ServiceReport')) {
            $serviceReportFile = $request->ServiceReport;
            $serviceReportPath = $serviceReportFile->storeAs($path, $serviceReportFile);
        }

        foreach ($resolved as $recId) {
            // Retrieve the Recommendations
            $recommendation = Recommendation::findOrFail($recId);

            if (isset($request->WONum)) $recommendation->wo_number = $request->WONum;
            if (isset($request->RecResolveDate)) $recommendation->rec_resolve_date = $recResolveDate;
            if (isset($request->ResolvedBy)) $recommendation->resolved_by = $request->ResolvedBy;
            $recommendation->resolved = 1;
            $recommendation->rec_status = "Complete";
            $recommendation->rec_resolve_ts = date("Y-m-d H:i:s");
            if (isset($serviceReportPath)) $recommendation->service_report_path = $serviceReportPath;

            $recommendation->save();
        }

        return redirect('/recommendations/' . $surveyID);
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
