<!-- resources/views/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2><span class="label label-default">Surveys to be scheduled ({{ $remain }}/{{ $total }})</span></h2>
<p>Click a link to schedule a survey for a unit</p>

<table class="table table-bordered table-condensed">
	<tbody>
@foreach ($machinesUntested->chunk(5) as $chunk )
		<tr>
		@foreach ($chunk as $machine)
			<td><a href="/surveys/{{ $machine->id}}/create">{{ $machine->description }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

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
			<td><a href="/machines/{{ $pending->machineId }}">{{ $pending->description }}</a></td>
			<td>{{ $pending->test_date}}</td>
			<td>{{ $pending->accession }}</td>
			<td>{{ $pending->notes }}</td>
		</tr>
@endforeach
	</tbody>
</table>

<h2><span class="label label-default">Survey Schedule</span></h2>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th><th>Description</th><th>Previous</th><th>Prev SurveyID</th><th>Current</th><th>Curr SurveyID</th><th>Recs</th><th>Recs Resolved</th>
		</tr>
	</thead>
	<tbody>
@foreach ($surveySchedule as $ss)
		<tr>
			<td>{{ $ss->id }}</td>
			<td><a href="/machines/{{ $ss->id }}">{{ $ss->description }}</a></td>
            <td>{{ $ss->prevSurveyDate }}</td>
		@if (empty($ss->prevSurveyReport))
            <td>{{ $ss->prevSurveyID }}</td>
		@else
            <td><a href="/report/survey/{{ $ss->prevSurveyID }}">{{ $ss->prevSurveyID }}</a></td>
		@endif
        <td>{{ $ss->currSurveyDate }}</td>
		@if (empty($ss->currSurveyReport))
            <td>{{ $ss->currSurveyID }}</td>
		@else
			<td><a href="/report/survey/{{ $ss->currSurveyID }}">{{ $ss->currSurveyID}}</a></td>
		@endif
			<td></td>
			<td></td>
		</tr>
@endforeach
	</tbody>
</table>
@endsection
