<?php

namespace RadDB\Http\Controllers;

use RadDB\Machine;
use RadDB\MachinePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
     * Method: GET
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

        return view('photos.photos_create',[
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
        $maxThumbWidth = 150;
        $machineId = $request->machineId;

        $path = env('MACHINE_PHOTO_PATH', 'public/photos/machines');
        // Store each photo in subdirectories by machine ID
        $path = $path.'/'.$machineId;
        $thumbPath = $path.'/thumb';

        $machinePhoto = new MachinePhoto();

        $machinePhoto->machine_id = $machineId;

        if ($request->hasFile('photo')) {
            list($w, $h, $imgType, $attr) = getimagesize($request->file('photo'));
            switch ($imgType) {
                case IMAGETYPE_GIF:
                    $photo = imagecreatefromgif($request->file('photo'));
                    break;
                case IMAGETYPE_JPEG:
                    $photo = imagecreatefromjpeg($request->file('photo'));
                    break;
                case IMAGETYPE_PNG:
                    $photo = imagecreatefrompng($request->file('photo'));
                    break;
                default:
                    break;
            }

            // Create a 150 px wide thumbnail image
            // Thumbnail height = 150 / aspect ratio
            $thumbHeight = ceil($maxThumbWidth/($w/$h));
            $photoThumb = imagecreatetruecolor($maxThumbWidth, $thumbHeight);
            $photoThumb = imagescale($photo, $maxThumbWidth, -1, IMG_BICUBIC);

            // Store the photo and thumbnail
            $machinePhoto->machine_photo_path = $request->file('photo')->store($path);
            $machinePhoto->machine_photo_thumb = ;
            imagejpeg($photoThumb, $machinePhoto->machine_photo_thumb);
            if (is_null($request->photoDescription)) {
                $machinePhoto->photo_description = null;
            }
            else {
                $machinePhoto->photo_description = $request->photoDescription;
            }

            // Save the record to the database
            if ($machinePhoto->save()) {
                $status = 'success';
                $message .= 'Photo for machine '.$machineId.' saved.';
                Log::info($message);
            }
            else {
                $status = 'fail';
                $message .= 'Error saving photo.';
                Log::error($message);
            }
        }

        return redirect()
            ->route('machines.show', $machineId)
            ->with($status, message);
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
    public function destroy($id)
    {
        //
    }
}
