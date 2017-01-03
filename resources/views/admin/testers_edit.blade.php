<!-- resources/views/admin/testers_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Tester</h2>

<form class="form-inline" action="/admin/testers/{{ $tester->id }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label for="name">Tester:</label> <input type="TEXT" class="form-control" id="name" name="name" size="20" value="{{ $tester->name }}">
		<label for="initials">Initials:</label> <input type="text" class="form-control" id="name" name="initials" size="4" value="{{ $tester->initials }}" >
		<button class="btn btn-default" type="SUBMIT">Edit tester</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
