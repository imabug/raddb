<!-- resources/views/admin/testtypes_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Test Type</h2>

<form action="/admin/testtypes/{{ $testtype->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
Test type: <input type="TEXT" name="testtypes" size="30" value="{{ $testtype->test_type }}"/>
<button type="SUBMIT">Edit test type</button> / <a href="/">Main</a>
</form>

@endsection
