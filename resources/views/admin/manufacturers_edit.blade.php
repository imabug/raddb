<!-- resources/views/admin/manufacturers_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Manufacturer</h2>

<form action="/admin/manufacturers/{{ $manufacturer->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
Manufacturer: <input type="TEXT" name="manufacturer" size="20" value="{{ $manufacturer->manufacturer }}"/>
<button type="SUBMIT">Edit manufacturer</button> / <a href="/">Main</a>
</form>

@endsection
