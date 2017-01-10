<!-- resources/views/admin/modality_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Modalities</h2>
<p>Click a modality to edit</p>
<table class="table">
	<tbody>
@foreach ($modalities->chunk(3) as $chunk )
		<tr>
		@foreach ($chunk as $modality)
			<td>{{ $modality->id }}</td>
			<td><a href="{{ route('modalities.edit', $modality->id) }}">{{ $modality->modality }}</a></td>
			<td>
				<form class="form-inline" action="{{ route('modalities.destroy', $modality->id) }}" method="post">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit" class="btn btn-danger btn-xs">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</form>
			</td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Modality</h2>
<!-- Add a new modality -->
<p>
<form class="form-inline" action="{{ route('modalities.store') }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="modality">New Modality:</label> <input type="TEXT" class="form-control" id="modality" name="modality" size="25" >
		<button class="btn btn-default" type="SUBMIT">Add modality</button>
	</div>
</form>
</p>
@endsection
