<!-- resources/views/admin/location_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Location</h2>

<form action="/admin/locations/{{ $location->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
Location: <input type="TEXT" name="location" size="20" value="{{ $location->location }}"/>
<button type="SUBMIT">Edit location</button> / <a href="/">Main</a>
</form>

@endsection
