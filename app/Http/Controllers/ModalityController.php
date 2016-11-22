<?php
namespace RadDB\Http\Controllers;

use Illuminate\Http\Request;
use RadDB\Http\Requests;
use RadDB\Modality;

class ModalityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show a list of the modalities
        $modalities = Modality::get();

        return view('admin.modalities_index', [
            'modalities' => $modalities
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
     * Add a new modality to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'modality' => 'required|string|max:25',
        ]);

        $modality = new Modality;
        $modality->modality = $request->modality;
        $modality->save();

        return redirect('/admin/modalities/');
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
     * Show the form for editing a modality
     * URI: /admin/modalities/$id/edit
     * Method: GET
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modality = Modality::findOrFail($id);

        return view('admin.modalities_edit', [
            'modality' => $modality
        ]);
    }

    /**
     * Update the modality.
     * URI: /admin/modalities/$id
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'modality' => 'required|string|max:20'
        ]);

        $modality = Modality::find($id);

        $modality->modality = $request->modality;

        $modality->save();

        return redirect('/admin/modalities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modality = Modality::find($id);

        $modality->delete();
        return redirect('/admin/modalities');
    }
}
