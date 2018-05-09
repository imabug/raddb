<!-- resources/views/ctdailyqc/ctdailyqc_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Show Daily CT QC</h2>
<p>Select a machine to show daily QC records.</p>
<table class="table table-bordered table-condensed">
	<tbody>
@foreach ($ctScanners->chunk(5) as $chunk )
		<tr>
		@foreach ($chunk as $scanner)
			<td><a href="{{ route('ctdailyqc.show', $scanner->id)}}">{{ $scanner->description }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>
<p><a href="{{ route('ctdailyqc.create') }}">Add a new QC record</a></p>
@endsection
