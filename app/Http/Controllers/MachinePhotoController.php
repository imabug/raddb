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
        $this->authorize('create', Machine::class);

        $machine = Machine::find($id);

        return view('photos.photos_create', [
            'machine' => $machine,
            'photos' => $machine->getMedia('machine_photos'),
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
        $machine = Machine::find($machineId);

        if ($request->hasFile('photo')) {
            // Associate the photo with the machine (spatie/medialibrary)
            // Collection name: machine_photos
            // Filesystem disk: MachinePhotos
            $machine->addMediaFromRequest('photo')
                ->preservingOriginal()
                ->toMediaCollection('machine_photos', 'MachinePhotos');

            $status = 'success';
            $message .= 'Photo for machine '.$machineId.' saved.';
            Log::info($message);
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
        return Machine::find($id)->getMedia('machine_photos');
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
        // spatie/medialibrary doesn't have a facility for removing media (yet)
        // so none of this applies yet. Will probably have to manually remove media
        // from the media table.
    }
}
