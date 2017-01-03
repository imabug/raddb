<!-- resources/views/admin/testtypes_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Test Type</h2>

<form class="form-inline" action="/admin/testtypes/{{ $testtype->id }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label for="testtype">Test type:</label> <input type="TEXT" class="form-control" id="testtype" name="testtype" size="30" value="{{ $testtype->test_type }}">
		<button class="btn btn-default" type="SUBMIT">Edit test type</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
