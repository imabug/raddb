<!-- resources/views/dashboard/survey_schedule.blade.php -->

@extends('layouts.app')

@section('content')

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
			<td><a href="{{ route('machines.show', $ss->id) }}">{{ $ss->description }}</a></td>
            <td>{{ $ss->prevSurveyDate }}</td>
		@if (empty($ss->prevSurveyReport))
            <td>{{ $ss->prevSurveyID }}</td>
		@else
            <td><a href="{{ route('reports.show', ["survey", $ss->prevSurveyID]) }}" target="_blank">{{ $ss->prevSurveyID }}</a></td>
		@endif
        <td>{{ $ss->currSurveyDate }}</td>
		@if (empty($ss->currSurveyReport))
            <td>{{ $ss->currSurveyID }}</td>
		@else
			<td><a href="{{ route('reports.show', ["survey", $ss->currSurveyID]) }}" target="_blank">{{ $ss->currSurveyID}}</a></td>
		@endif
			<td></td>
			<td></td>
		</tr>
@endforeach
	</tbody>
</table>

@endsection
