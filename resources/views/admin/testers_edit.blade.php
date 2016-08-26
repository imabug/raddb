<!-- resources/views/admin/testers_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Tester</h2>

<form action="/admin/testers/{{ $tester->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
<label>Tester:</label> <input type="TEXT" name="name" size="20" value="{{ $tester->name }}"/>
<label>Initials:</label> <input type="text" name="initials" size="4" value="{{ $tester->initials }}" />
<button type="SUBMIT">Edit tester</button> / <a href="/">Main</a>
</form>

@endsection
