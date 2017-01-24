<?php

namespace RadDB\Http\Controllers;

use RadDB\Tester;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\UpdateTestDateRequest;

class TestDateController extends Controller
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
     * Fetch the survey report path for a survey.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSurveyReportPath($id)
    {
        $surveyReportPath = TestDate::select('report_file_path')->findOrFail($id);

        return $surveyReportPath;
    }

    /**
     * Show a form for creating a new survey.
     * This method is called with an optional parameter $id which corresponds to
     * the machine ID the survey is being created for.
     * URI: /surveys/$id/create
     * Method: GET.
     *
     * @param int $machineId (optional)
     *
     * @return \Illuminate\Http\Response
     */
    public function create($machineId = null)
    {
        $testers = Tester::select('id', 'initials')
            ->get();
        $testtypes = TestType::select('id', 'test_type')
            ->get();

        if (is_null($machineId)) {
            $machines = Machine::select('id', 'description')
                ->active()
                ->orderBy('description')
                ->get();
        } else {
            $machines = Machine::select('id', 'description')
                ->findOrFail($machineId);
        }

        return view('surveys.surveys_create', [
            'id'        => $machineId,
            'testers'   => $testers,
            'testtypes' => $testtypes,
            'machines'  => $machines,
        ]);
    }

    /**
     * Save survey data to the database
     * URI: /surveys
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateTestDateRequest $request)
    {
        $this->validate($request, [
        ]);

        $testdate = new TestDate();

        $testdate->test_date = $request->test_date;
        $testdate->machine_id = $request->machineID;
        $testdate->tester1_id = $request->tester1ID;
        if (! empty($request->tester2ID)) {
            $testdate->tester2_id = $request->tester2ID;
        } else {
            $testdate->tester2_id = 10;
        }
        $testdate->type_id = $request->test_type;
        if (! empty($request->notes)) {
            $testdate->notes = $request->notes;
        }
        if (! empty($request->accession)) {
            $testdate->accession = $request->accession;
        }

        $saved = $testdate->save();
        if ($saved) {
            $message = 'Survey '.$testdate->id.' added.';
            Log::info($message);

            return redirect()->route('index')->with('success', 'Survey added');
        } else {
            return redirect()->route('index')->with('fail', 'Error adding survey');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show a form for editing a survey. Typically used to edit the survey date.
     * URI: /surveys/$id/edit
     * Method: Get.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($surveyId)
    {
        $testers = Tester::select('id', 'initials')
            ->get();
        $testtypes = TestType::select('id', 'test_type')
            ->get();

        // Retrieve survey information for $id
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);
        $tester1 = Tester::find($survey->tester1_id);
        if ($survey->tester2_id != 0) {
            $tester2 = Tester::find($survey->tester2_id);
        } else {
            $tester2 = null;
        }
        $testtype = TestType::find($survey->type_id);

        return view('surveys.surveys_edit', [
            'survey'    => $survey,
            'machine'   => $machine,
            'tester1'   => $tester1,
            'tester2'   => $tester2,
            'testtype'  => $testtype,
            'testers'   => $testers,
            'testtypes' => $testtypes,
        ]);
    }

    /**
     * Update the survey info for $surveyId.
     * URI: /surveys/$surveyId
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestDateRequest $request, $surveyId)
    {
        $this->validate($request, [
        ]);

        $testdate = TestDate::find($surveyId);

        if ($testdate->test_date != $request->test_date) {
            $testdate->test_date = $request->test_date;
        }
        if ($testdate->tester1_id != $request->tester1ID) {
            $testdate->tester1_id = $request->tester1ID;
        }
        if ($testdate->tester2_id != $request->tester2ID) {
            $testdate->tester2_id = $request->tester2ID;
        }
        if ($testdate->notes != $request->notes) {
            $testdate->notes = $request->notes;
        }
        if ($testdate->accession != $request->accession) {
            $testdate->accession = $request->accession;
        }

        $saved = $testdate->save();
        if ($saved) {
            $message = 'Survey '.$testdate->id.' edited.';
            Log::info($message);

            return redirect()->route('index')->with('success', 'Survey edited');
        } else {
            return redirect()->route('index')->with('fail', 'Error editing survey');
        }
    }

    /**
     * Show a form for adding a new survey report.
     * URI: /surveys/addReport
     * Method: GET.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addSurveyReport(Request $request)
    {
        // TODO: Have the survey ID as an optional parameter.
        // URI: /surveys/{surveyId?}/addReport
        // In the initial attempt, route matching failed when the survey ID
        // wasn't provided in the URI.

        return view('surveys.surveys_addReport');
    }

    /**
     * Handle an uploaded survey report
     * URI: /surveys/addReport
     * Method: PUT.
     *
     * @param int                      $surveyId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSurveyReport(Request $request)
    {
        $this->validate($request, [
            'surveyId'     => 'required||exists:testdates,id|integer',
            'surveyReport' => 'required|file|mimes:pdf',
        ]);

        $testdate = TestDate::find($request->surveyId);

        // Handle the uploaded file
        // This breaks the way service reports were handled in the previous version. Deal with it.

        if ($request->hasFile('surveyReport')) {
            $surveyReportPath = $request->surveyReport->store('public/SurveyReports');
            $testdate->report_file_path = $surveyReportPath;
        }

        $saved = $testdate->save();
        if ($saved) {
            $message = 'Survey report for survey '.$testdate->id.' stored.';
            Log::info($message);

            return redirect()->route('index')->with('success', 'Survey report uploaded');
        } else {
            return redirect()->route('index')->with('fail', 'Error uploading survey report');
        }
    }

    /**
     * Not implemented. Should not be able to remove surveys from the database.
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
