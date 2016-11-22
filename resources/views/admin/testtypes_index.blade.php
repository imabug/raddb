<!-- resources/views/admin/testtype_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Test Types</h2>
<p>Click a test type to edit</p>
<table class="table">
	<tbody>
@foreach ($testtypes->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $testtype)
			<td>{{ $testtype->id }}</td>
			<td><a href="/admin/testtypes/{{ $testtype->id }}/edit">{{ $testtype->test_type }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Test Type</h2>
<!-- Add a new test type -->
<form class="form-inline" action="/admin/testtypes" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="testtype">New Test Type:</label> <input class="form-control" type="TEXT" id="testtype" name="testtype" size="30" />
		<button class="btn btn-default" type="SUBMIT">Add test type</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
