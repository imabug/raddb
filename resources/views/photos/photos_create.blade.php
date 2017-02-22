<!-- resources/views/photos/photos_create.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Add photo for {{ $machine->description }}</h2>
@if($photos->count() > 0)
@foreach ($photos as $photo)

@endforeach
@endif
<form class="form-inline" action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="machineId" value="{{ $machine->id }}">
        <p><label for="photo">Upload photo: </label> <input class="form-control" type="file" id="photo" name="photo" ></p>
        <p><button type="submit">Submit survey report</button></p>
    </div>
</form>

@endsection
