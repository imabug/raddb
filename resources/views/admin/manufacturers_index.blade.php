<!-- resources/views/admin/manufacturer_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>

<table>
@foreach ($manufacturers->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $manufacturer)
		<td>{{ $manufacturer->id }}</td>
		<td>{{ $manufacturer->manufacturer }}</td>
	@endforeach
	</tr>
@endforeach
</table>

@endsection
