<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTestDateRequest;
use App\Models\Machine;
use App\Models\TestDate;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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
     *
     * This method is called with an optional parameter $id which corresponds to
     * the machine ID the survey is being created for.
     *
     * URI: /surveys/$id/create
     *
     * Method: GET
     *
     * @param string $id (optional)
     */
    public function create(string $id = null): View
    {
        if (is_null($id)) {
            $machines = Machine::select('id', 'description')
                ->active()
                ->orderBy('description')
                ->get();
        } else {
            $machines = Machine::select('id', 'description')
                ->findOrFail((int) $id);
        }

        return view('surveys.surveys_create', [
            'id'        => $id,
            'testers'   => Tester::get(),
            'testtypes' => TestType::get(),
            'machines'  => $machines,
        ]);
    }

    /**
     * Save survey data to the database.
     *
     * Form data is validated by App\Http\Requests\UpdateTestDataRequest.
     * User is redirected to the home page after the survey is updated.
     *
     * URI: /surveys
     *
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(UpdateTestDateRequest $request, TestDate $testdate): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';
        $status = '';

        $testdate->test_date = $request->test_date;
        $testdate->machine_id = $request->machineID;
        $testdate->tester1_id = $request->tester1ID;
        $testdate->tester2_id = $request->has('tester2ID') ? $request->tester2_id : null;
        $testdate->type_id = $request->test_type;
        $testdate->notes = $request->has('notes') ? $request->notes : null;
        $testdate->accession = $request->has('accession') ? $request->accession : null;

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
     * Show a form for editing a survey. Typically used to edit the survey date.
     *
     * URI: /surveys/$id/edit
     *
     * Method: Get.
     *
     * @param int $id
     */
    public function edit(int $id): View
    {
        $survey = TestDate::findOrFail($id);

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
     *
     * Form data is validated by App\Http\Requests\UpdateTestDateRequest.
     * User is redirected to the home page after updating.
     *
     * URI: /surveys/$surveyId
     *
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $surveyId
     */
    public function update(UpdateTestDateRequest $request, $surveyId): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';
        $status = '';

        $testdate = TestDate::find($surveyId);

        $testdate->test_date = $request->test_date;
        $testdate->tester1_id = $request->tester1ID;
        $testdate->tester2_id = $request->has('tester2ID') ? $request->tester2ID : null;
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
     *
     * This method is called with the survey Id (required) to cancel.
     *
     * URI: /surveys/$surveyId/cancel
     *
     * Method: POST.
     *
     * @param int $surveyId
     */
    public function cancel(int $surveyId): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(TestDate::class);

        $message = '';
        $status = '';

        if (TestDate::findOrFail($surveyId)->delete()) {
            $status = 'success';
            $message .= 'Survey '.$surveyId.' canceled.';
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
