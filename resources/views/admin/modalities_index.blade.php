<!-- resources/views/admin/modality_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Modalities</h2>

<table class="table">
	<tbody>
@foreach ($modalities->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $modality)
			<td>{{ $modality->id }}</td>
			<td>{{ $modality->modality }}</td>
			<form action="/admin/modalities/{{ $modality->id }}/edit" method="POST">
				<button type="submit">Edit</button>
			</form>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Modality</h2>
<!-- Add a new modality -->
<form action="/admin/modalities" method="POST">
	{{ csrf_field() }}
New Modality: <input type="TEXT" name="modality" size="25" />
<button type="SUBMIT">Add modality</button> / <a href="/">Main</a>
</form>

@endsection
