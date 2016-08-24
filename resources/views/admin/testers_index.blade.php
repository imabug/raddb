<!-- resources/views/admin/tester_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>

<table>
@foreach ($testers->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $tester)
		<td>{{ $tester->id }}</td>
		<td>{{ $tester->name }}</td>
	@endforeach
	</tr>
@endforeach
</table>

@endsection
