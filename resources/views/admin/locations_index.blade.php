<!-- resources/views/admin/location_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>

<table>
@foreach ($locations->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $location)
		<td>{{ $location->id }}</td>
		<td>{{ $location->location }}</td>
		<td>
			<form action="/admin/locations/{{ $location->id }}/edit" method="POST">
				<button type="submit">Edit</button>
			</form>
		</td>
	@endforeach
	</tr>
@endforeach
</table>

<h2>Add a Location</h2>
<!-- Add a new location -->
<form action="/admin/locations" method="POST">
	{{ csrf_field() }}
New Location: <input type="TEXT" name="location" size="20" />
<button type="SUBMIT">Add location</button> / <a href="/">Main</a>
</form>

@endsection
