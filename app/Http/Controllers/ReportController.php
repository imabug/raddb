<?php

namespace RadDB\Http\Controllers;

use RadDB\TestDate;
use RadDB\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the requested report.
     *
     * @param string $type
     * @param int    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        switch ($type) {
            case 'survey':
                $survey = TestDate::findOrFail($id);
                if (Storage::exists($survey->report_file_path)) {
                    return redirect(Storage::url($survey->report_file_path));
                } else {
                    return redirect()->route('machines.show', $id);
                }
                break;
            case 'service':
                $rec = Recommendation::findOrFail($id);
                if (Storage::exists($rec->service_report_path)) {
                    return redirect(Storage::url($rec->service_report_path));
                } else {
                    return redirect()->route('recommendations.show'.$rec->survey_id);
                }
                break;
            default:
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
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
     * @param int                      $id
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
