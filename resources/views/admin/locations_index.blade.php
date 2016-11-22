<!-- resources/views/admin/location_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>
<p>Click a location to edit</p>
<table class="table">
	<tbody>
@foreach ($locations->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $location)
			<td>{{ $location->id }}</td>
			<td><a href="/admin/locations/{{ $location->id }}/edit">{{ $location->location }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Location</h2>
<!-- Add a new location -->
<form class="form-inline" action="/admin/locations" method="POST">
	<div class="form-group">
	{{ csrf_field() }}
<label for="location">New Location:</label> <input type="TEXT" class="form-control" id="location" name="location" size="20" placeholder="Location" />
<button type="SUBMIT" class="btn btn-default">Add location</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
