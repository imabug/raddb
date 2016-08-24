<!-- resources/views/admin/testtype_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>

<table>
@foreach ($testtypes->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $testtype)
		<td>{{ $testtype->id }}</td>
		<td>{{ $testtype->test_type }}</td>
	@endforeach
	</tr>
@endforeach
</table>

@endsection
