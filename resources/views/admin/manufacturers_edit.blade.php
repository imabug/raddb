<!-- resources/views/admin/manufacturers_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Manufacturer</h2>

<form class="form-inline" action="/admin/manufacturers/{{ $manufacturer->id }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label for"manufacturer">Manufacturer:</label> <input class="form-control" type="TEXT" id="manufacturer" name="manufacturer" size="20" value="{{ $manufacturer->manufacturer }}" >
		<button class="btn btn-default" type="SUBMIT">Edit manufacturer</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
