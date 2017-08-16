<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\MachinePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RadDB\Http\Requests\StoreMachinePhotoRequest;

class MachinePhotoController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only apply auth middleware to these methods
        $this->middleware('auth')->only([
             'create',
             'store',
             'edit',
             'update',
             'destroy',
         ]);
    }

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
     * Show the form for adding a new photo.
     * URI: photos/{id}/create
     * Method: GET.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('create', MachinePhoto::class);

        // $id is the machine ID to add the photo to.
        $machine = Machine::find($id);
        $photos = MachinePhoto::where('machine_id', $id)->get();

        return view('photos.photos_create', [
            'machine' => $machine,
            'photos' => $photos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMachinePhotoRequest $request)
    {
        $this->authorize('store', MachinePhoto::class);

        $message = '';
        $machineId = $request->machineId;

        $path = env('MACHINE_PHOTO_PATH', 'public/photos/machines');
        // Store each photo in subdirectories by machine ID
        $path = $path.'/'.$machineId;

        $machinePhoto = new MachinePhoto();

        $machinePhoto->machine_id = $machineId;

        if ($request->hasFile('photo')) {
            // Store the photo and thumbnail
            $machinePhoto->machine_photo_path = $request->file('photo')->store($path);

            if (is_null($request->photoDescription)) {
                $machinePhoto->photo_description = null;
            } else {
                $machinePhoto->photo_description = $request->photoDescription;
            }

            // Save the record to the database
            if ($machinePhoto->save()) {
                $status = 'success';
                $message .= 'Photo for machine '.$machineId.' saved.';
                Log::info($message);
            } else {
                $status = 'fail';
                $message .= 'Error saving photo.';
                Log::error($message);
            }
        }

        return redirect()
            ->route('machines.show', $machineId)
            ->with($status, $message);
    }

    /**
     * Display the photos for machine $id.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        return MachinePhoto::where('machine_id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove photo with id $id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('destroy', MachinePhoto::class);
        $message = '';
        $machineId = $request->machineId;

        $machinePhoto = MachinePhoto::find($id);

        if ($machinePhoto->delete()) {
            $status = 'success';
            $message .= 'Photo for machine '.$machineId.' deleted.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error deleting photo.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $machineId)
            ->with($status, $message);
    }
}
