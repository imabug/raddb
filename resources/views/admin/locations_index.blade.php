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
	@endforeach
	</tr>
@endforeach
</table>

@endsection
