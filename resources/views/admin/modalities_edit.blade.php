<!-- resources/views/admin/modalities_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Modality</h2>

<form class="form-inline" action="/admin/modalities/{{ $modality->id }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label for="modality">Modality:</label> <input type="TEXT" class="form-control" id="modality" name="modality" size="20" value="{{ $modality->modality }}">
		<button  class="btn btn-default"type="SUBMIT">Edit modality</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
