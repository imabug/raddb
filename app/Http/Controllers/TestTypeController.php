<?php

namespace RadDB\Http\Controllers;

use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\TestTypeRequest;
use RadDB\Models\TestType;

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
    }
}
