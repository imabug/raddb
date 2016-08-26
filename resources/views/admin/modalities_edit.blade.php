<!-- resources/views/admin/modalities_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit Modality</h2>

<form action="/admin/modalities/{{ $modality->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
Modality: <input type="TEXT" name="modality" size="20" value="{{ $modality->modality }}"/>
<button type="SUBMIT">Edit modality</button> / <a href="/">Main</a>
</form>

@endsection
