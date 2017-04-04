<?php

namespace RadDB\Http\Controllers;

use RadDB\TestType;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\TestTypeRequest;

class TestTypeController extends Controller
{
    /**
      * Instantiate a new controller instance.
      *
      * @return void
      */
     public function __construct()
     {
         $this->middleware('auth')->only([
             'create',
             'edit',
             'store',
             'update',
             'destroy',
         ]);
     }

    /**
     * Display a listing of test types.
     * URI: /admin/testtypes
     * Method: GET.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the locations
        $testtypes = TestType::get();

        return view('admin.testtypes_index', [
            'testtypes' => $testtypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Add a new test type to the database.
     * URI: /admin/testtypes
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TestTypeRequest $request)
    {
        // Check if action is allowed
        $this->authorize(TestType::class);

        $testtype = new TestType();
        $testtype->test_type = $request->testtype;
        if ($testtype->save()) {
            $message = 'Test type '.$testtype->test_type.' added.';
            Log::info($message);
        }

        return redirect()->route('testtypes.index');
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
     * Show the form for editing a test type
     * URI: /admin/testtypes/$id/edit
     * Method: GET.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.testtypes_edit', [
            'testtype' => TestType::findOrFail($id),
        ]);
    }

    /**
     * Update the test type.
     * URI: /admin/testtypes/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TestTypeRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(TestType::class);

        $testtype = TestType::find($id);

        $testtype->test_type = $request->testtype;

        if ($testtype->save()) {
            $message = 'Test type '.$testtype->id.' edited.';
            Log::info($message);
        }

        return redirect()->route('testtypes.index');
    }

    /**
     * Remove the specified resource from storage.
     * URI: /admin/testtypes/$id
     * Method: DELETE.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if action is allowed
        $this->authorize(TestType::class);

        $testtype = TestType::find($id);

        if ($testtype->delete()) {
            $message = 'Test type '.$testtype->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('testtypes.index');
    }
}
