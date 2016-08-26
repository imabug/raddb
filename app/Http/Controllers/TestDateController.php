<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Machine;
use RadDB\Tester;
use RadDB\TestType;
use RadDB\Http\Requests;

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
     * Fetch the survey report path for a survey
     *
     * @param int $id
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
     * Method: GET
     *
     * @param int $id (optional)
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $testers = Tester::select('id', 'initials')
            ->get();
        $testtypes = TestType::select('id', 'test_type')
            ->get();

        if (isset($id)) {
            $machines = Machine::select('id', 'description')
                ->findOrFail($id);
        }
        else {
            $machines = Machine::select('id', 'description')
                ->get();
        }

        return view('surveys.surveys_create', [
            'id' => $id,
            'testers' => $testers,
            'testtypes' => $testtypes,
            'machines' => $machines
        ]);
    }

    /**
     * Save survey data to the database
     * URI: /surveys
     * Method: POST
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'machineID' => 'required|integer',
            'test_date' => 'required|date_format:Y-m-d|max:10',
            'tester1ID' => 'required|string|max:4',
            'tester2ID' => 'string|max:4',
            'test_type' => 'required|integer',
            'notes' => 'string|max:65535',
            'accession' => 'numeric'
        ]);

        $testdate = new TestDate;

        $testdate->machine_id = $request->machineID;
        $testdate->test_date = $request->test_date;
        $testdate->tester1_id = $request->tester1ID;
        if (!empty($request->tester2ID)) $testdate->tester2_id = $request->tester2ID;
        $testdate->type_id = $request->test_type;
        if (!empty($request->notes)) $testdate->notes = $request->notes;
        if (!empty($request->accession)) $testdate->accession = $request->accession;

        $testdate->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
