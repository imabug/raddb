<!-- resources/views/photos/photos_create.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Add photo for {{ $machine->description }}</h2>
@if($photos->count() > 0)
<table class="table table-bordered table-condensed">
    <tbody>
@foreach ($photos->chunk(4) as $photo_chunk)
        <tr>
    @foreach ($photo_chunk as $photo)
            <td><a href="{{ $photo->machine_photo_path }}" target="_blank"><img src="{{ $photo->machine_photo_thumb}}" alt="{{ $photo->photo_description }}"></a></td>
    @endforeach
        </tr>
@endforeach
    </tbody>
</table>
@endif
<form class="form-inline" action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
        <p><label for="photoDescription">Photo description: </label><input class="form-control" type="text" id="photoDescription" name="photoDescription"></p>
        <p><label for="photo">Upload photo: </label> <input class="form-control" type="file" id="photo" name="photo" ></p>
        <p><button class="form-control" type="submit">Add photo</button></p>
    </div>
</form>

@endsection
