<?php

namespace RadDB\Http\Controllers;

use RadDB\Tester;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\TesterRequest;

class TesterController extends Controller
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
     * Show a list of the testers.
     * URI: /admin/testers
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
     * Add a new tester to the database.
     * URI: /admin/testers
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TesterRequest $request)
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
     * Show the form for editing a tester
     * URI: /admin/testers/$id/edit
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
     * Update the tester.
     * URI: /admin/testers/$id
     * Method: PUT.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TesterRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * URI: /admin/testers/$id
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
