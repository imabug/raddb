<!-- resources/views/dashboard/pending.blade.php -->

@extends('layouts.app')

@section('content')

<h2><span class="label label-default">Pending surveys</span></h2>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Survey ID</th><th>Description</th><th>Date Scheduled</th><th>Accession</th><th>Survey Note</th>
		</tr>
	</thead>
	<tbody>
@foreach ($pendingSurveys as $pending)
		<tr>
			<td>{{ $pending->surveyId }}</td>
			<td><a href="{{ route('machines.show', $pending->machineId) }}">{{ $pending->description }}</a></td>
			<td>{{ $pending->test_date}}</td>
			<td>{{ $pending->accession }}</td>
			<td>{{ $pending->notes }}</td>
		</tr>
@endforeach
	</tbody>
</table>

@endsection
