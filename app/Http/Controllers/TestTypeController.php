<?php

namespace RadDB\Http\Controllers;

use RadDB\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
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
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'testtype' => 'required|string|max:30',
        ]);

        $testtype = new TestType();
        $testtype->test_type = $request->testtype;
        $saved = $testtype->save();
        if ($saved) {
            $message = "Test type " . $testtype->test_type . " added.";
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
        $testtype = TestType::findOrFail($id);

        return view('admin.testtypes_edit', [
            'testtype' => $testtype,
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'testtype' => 'required|string|max:30',
        ]);

        $testtype = TestType::find($id);

        $testtype->test_type = $request->testtype;

        $saved = $testtype->save();
        if ($saved) {
            $message = "Test type " . $testtype->id . " edited.";
            Log::info($message);
        }

        return redirect()->route('testtypes.index');
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
        $testtype = TestType::find($id);

        $deleted = $testtype->delete();
        if ($deleted) {
            $message = "Test type " . $testtype->id . " deleted.";
            Log::notice($message);
        }

        return redirect()->route('testtypes.index');
    }
}
