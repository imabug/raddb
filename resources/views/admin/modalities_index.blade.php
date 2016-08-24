<!-- resources/views/admin/modality_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Locations</h2>

<table>
@foreach ($modalities->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $modality)
		<td>{{ $modality->id }}</td>
		<td>{{ $modality->modality }}</td>
	@endforeach
	</tr>
@endforeach
</table>

@endsection
