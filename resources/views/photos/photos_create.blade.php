{{-- resources/views/photos/photos_create.blade.php --}}
{{-- Used by the create() method in MachinePhotoController --}}
@extends('layouts.app')

@section('content')
  <h2>Add photo for {{ $machine->description }}</h2>
  @if($photos->count() > 0)
    <table class="table table-bordered table-condensed">
      <tbody>
        @foreach ($photos->chunk(4) as $photo_chunk)
          <tr>
            @foreach ($photo_chunk as $photo)
              <td>
                <a href="{{ Storage::disk('MachinePhotos')->url($photo->machine_photo_path) }}" target="_blank">
                  <img src="{{ Storage::disk('MachinePhotos')->url($photo->machine_photo_path)}}" alt="{{ $photo->photo_description }}" width="150">
                </a>
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  <form class="form-inline" action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
      @csrf
      <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
      <p><label for="photoDescription">Photo description: </label><input class="form-control" type="text" id="photoDescription" name="photoDescription"></p>
      <p><label for="photo">Upload photo: </label> <input class="form-control" type="file" id="photo" name="photo" ></p>
      <p><button class="form-control" type="submit">Add photo</button></p>
    </div>
  </form>

@endsection
