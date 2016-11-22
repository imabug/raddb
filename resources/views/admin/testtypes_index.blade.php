<!-- resources/views/admin/testtype_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Test Types</h2>

<table class="table">
	<tbody>
@foreach ($testtypes->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $testtype)
			<td>{{ $testtype->id }}</td>
			<td>{{ $testtype->test_type }}</td>
			<form action="/admin/testtypes/{{ $testtype->id }}/edit" method="POST">
				<button type="submit">Edit</button>
			</form>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Test Type</h2>
<!-- Add a new test type -->
<form action="/admin/testtypes" method="POST">
	{{ csrf_field() }}
New Test Type: <input type="TEXT" name="testtype" size="30" />
<button type="SUBMIT">Add test type</button> / <a href="/">Main</a>
</form>

@endsection
