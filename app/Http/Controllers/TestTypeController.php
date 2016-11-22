<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Http\Requests;
use RadDB\TestType;

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
            'testtypes' => $testtypes
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
     * Add a new test type to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'testtype' => 'required|string|max:30',
        ]);

        $testtype = new TestType;
        $testtype->test_type = $request->testtype;
        $testtype->save();

        return redirect('/admin/testtypes/');
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
     * Show the form for editing a test type
     * URI: /admin/testtypes/$id/edit
     * Method: GET
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testtype = TestType::findOrFail($id);

        return view('admin.testtypes_edit', [
            'testtype' => $testtype
        ]);
    }

    /**
     * Update the test type.
     * URI: /admin/testtypes/$id
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'testtype' => 'required|string|max:30'
        ]);

        $testtype = TestType::find($id);

        $testtype->test_type = $request->testtype;

        $testtype->save();

        return redirect('/admin/testtypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testtype = TestType::find($id);

        $testtype->delete();
        return redirect('/admin/testtypes');
    }
}
