<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTestDateRequest;
use App\Models\Machine;
use App\Models\TestDate;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Support\Facades\Log;

class TestDateController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only use these methods with the auth middlware
        $this->middleware('auth')->only([
            'create',
            'edit',
            'store',
            'update',
            'cancel',
        ]);
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
            'testers'   => Tester::get(),
            'testtypes' => TestType::get(),
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
    public function store(UpdateTestDateRequest $request, TestDate $testdate)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';

        $testdate->test_date = $request->test_date;
        $testdate->machine_id = $request->machineID;
        $testdate->tester1_id = $request->tester1ID;
        if (empty($request->tester2ID)) {
            $testdate->tester2_id = null;
        } else {
            $testdate->tester2_id = $request->tester2ID;
        }
        $testdate->type_id = $request->test_type;
        if (!empty($request->notes)) {
            $testdate->notes = $request->notes;
        }
        if (!empty($request->accession)) {
            $testdate->accession = $request->accession;
        }

        if ($testdate->save()) {
            $status = 'success';
            $message .= 'Survey '.$testdate->id.' added.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error adding survey.';
            Log::error($message);
        }

        return redirect()
            ->route('index')
            ->with($status, $message);
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
     * @param int $surveyId
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $surveyId)
    {
        $survey = TestDate::findOrFail($surveyId);

        // Return survey information for $id
        return view('surveys.surveys_edit', [
            'survey'    => $survey,
            'machine'   => $survey->machine,
            'tester1'   => $survey->tester1,
            'tester2'   => $survey->tester2,
            'testtype'  => $survey->type,
            'testers'   => Tester::get(),
            'testtypes' => TestType::get(),
        ]);
    }

    /**
     * Update the survey info for $surveyId.
     * URI: /surveys/$surveyId
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $surveyId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestDateRequest $request, $surveyId)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';

        $testdate = TestDate::find($surveyId);

        $testdate->test_date = $request->test_date;
        $testdate->tester1_id = $request->tester1ID;
        if (empty($request->tester2ID)) {
            $testdate->tester2_id = null;
        } else {
            $testdate->tester2_id = $request->tester2ID;
        }
        $testdate->notes = $request->notes;
        $testdate->accession = $request->accession;
        $testdate->type_id = $request->test_type;

        if ($testdate->save()) {
            $status = 'success';
            $message .= 'Survey '.$testdate->id.' edited.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error editing survey.';
            Log::error($message);
        }

        return redirect()
            ->route('index')
            ->with($status, $message);
    }

    /**
     * Cancel a survey.
     * This method is called with the survey Id (required) to cancel.
     * URI: /surveys/$surveyId/cancel
     * Method: POST.
     *
     * @param int $surveyId
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($surveyId)
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';

        $testdate = TestDate::findOrFail($surveyId);
        if ($testdate->delete()) {
            $status = 'success';
            $message .= 'Survey '.$testdate->id.' canceled.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Unable to cancel survey.';
            Log::error($message);
        }

        return redirect()
            ->route('index')
            ->with($status, $message);
    }
}
