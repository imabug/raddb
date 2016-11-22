<!-- resources/views/admin/modality_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Modalities</h2>
<p>Click a modality to edit</p>
<table class="table">
	<tbody>
@foreach ($modalities->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $modality)
			<td>{{ $modality->id }}</td>
			<td><a href="/admin/modalities/{{ $modality->id }}/edit">{{ $modality->modality }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Modality</h2>
<!-- Add a new modality -->
<form class="form-inline" action="/admin/modalities" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="modality">New Modality:</label> <input type="TEXT" class="form-control" id="modality" name="modality" size="25" />
		<button class="btn btn-default" type="SUBMIT">Add modality</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
