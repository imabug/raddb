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
         $this->middleware('auth');
     }

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
    public function store(TesterRequest $request)
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $tester = new Tester();
        $tester->name = $request->name;
        $tester->initials = $request->initials;
        $saved = $tester->save();
        if ($saved) {
            $message = 'Tester '.$tester->name.' added.';
            Log::info($message);
        }

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
    public function update(TesterRequest $request, $id)
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $tester = Tester::find($id);

        $tester->name = $request->name;
        $tester->initials = $request->initials;

        $saved = $tester->save();
        if ($saved) {
            $message = 'Tester ID '.$tester->id.' edited.';
            Log::info($message);
        }

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
        // Check if action is allowed
        $this->authorize(Machine::class);

        $tester = Tester::find($id);

        $deleted = $tester->delete();
        if ($deleted) {
            $message = 'Tester ID '.$tester->id.' deleted.';
            Log::notice($message);
        }

        return redirect()->route('testers.index');
    }
}
