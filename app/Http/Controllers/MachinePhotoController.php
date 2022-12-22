<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachinePhotoRequest;
use App\Models\Machine;
use Illuminate\Support\Facades\Log;

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
     * Show the form for adding a new photo.
     *
     * URI: photos/{id}/create
     *
     * Method: GET.
     *
     * @param string $id
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($id)
    {
        $this->authorize('create', Machine::class);

        $machine = Machine::find((int) $id);

        return view('photos.photos_create', [
            'machine' => $machine,
            'photos'  => $machine->getMedia('machine_photos'),
        ]);
    }

    /**
     * Store the photo for a machine.
     *
     * Form data is validated by App\Http\Requests\StoreMachinePhotoRequest before
     * being added to the media collection.  User is redirected to the machine
     * information page upon completion.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMachinePhotoRequest $request)
    {
        (string) $message = '';
        $machine = Machine::find($request->machineId);

        if ($request->hasFile('photo')) {
            // Associate the photo with the machine (spatie/medialibrary)
            // Collection name: machine_photos
            // Filesystem disk: MachinePhotos
            $machine->addMediaFromRequest('photo')
                ->preservingOriginal()
                ->toMediaCollection('machine_photos', 'MachinePhotos');

            $status = 'success';
            $message .= 'Photo for machine '.$machine->id.' saved.';
            Log::info($message);
        }

        return redirect()
            ->route('machines.show', $machine->id)
            ->with($status, $message);
    }

    /**
     * Display the photos for machine $id.
     *
     * @param string $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        return Machine::find((int) $id)->getMedia('machine_photos');
    }
}
