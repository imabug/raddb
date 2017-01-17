<?php

namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Tester;

class TesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the locations
        $testers = Tester::get();

        return view('admin.testers_index', [
            'testers' => $testers,
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
     * Add a new tester to the database.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:25',
            'initials' => 'required|string|max:3',
        ]);

        $tester = new Tester();
        $tester->name = $request->name;
        $tester->initials = $request->initials;
        $tester->save();

        return redirect()->route('testers.index');
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
        $tester = Tester::findOrFail($id);

        return view('admin.testers_edit', [
            'tester' => $tester,
        ]);
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:20',
            'initials' => 'required|string|max:4',
        ]);

        $tester = Tester::find($id);

        $tester->name = $request->name;
        $tester->initials = $request->initials;

        $tester->save();

        return redirect()->route('testers.index');
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
        $tester = Tester::find($id);

        $tester->delete();

        return redirect()->route('testers.index');
    }
}
