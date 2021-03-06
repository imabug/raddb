<!-- resources/views/admin/location_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Location</h2>
<p>
<form class="form-inline" action="{{ route('locations.update', $location->id) }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label for="location">Location:</label> <input type="TEXT" class="form-control" id="location" name="location" size="20" value="{{ $location->location }}">
		<button class="btn btn-default" type="SUBMIT">Edit location</button>
	</div>
</form>
</p>
@endsection
