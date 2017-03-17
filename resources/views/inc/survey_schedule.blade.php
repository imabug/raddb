<h2><span class="label label-default">Survey Schedule</span></h2>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
            <th>Description</th>
            <th>Previous</th>
            <th>Prev SurveyID</th>
            <th>Current</th>
            <th>Curr SurveyID</th>
		</tr>
	</thead>
	<tbody>
@foreach ($surveySchedule as $ss)
		<tr>
			<td>{{ $ss->id }}</td>
			<td><a href="{{ route('machines.show', $ss->id) }}">{{ $ss->description }}</a></td>
        @if ($ss->prevRecCount > 0)
            <td><a href="{{ route('recommendations.show', $ss->prevSurveyID)}}" title="Recommendations" alt="Recommendations">{{ $ss->prevSurveyDate }}</a></td>
        @else
            <td>{{ $ss->prevSurveyDate }}</td>
        @endif
		@if (Storage::exists($ss->prevSurveyReport))
            <td>{{ $ss->prevSurveyID }}
                <a href="{{ Storage::url($ss->prevSurveyReport) }}" target="_blank" title="Survey report" alt="Survey report">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </a>
            </td>
		@else
            <td>{{ $ss->prevSurveyID }}</td>
		@endif
        @if ($ss->currRecCount > 0)
            <td><a href="{{ route('recommendations.show', $ss->currSurveyID)}}" title="Recommendations" alt="Recommendations">{{ $ss->currSurveyDate }}</a></td>
        @else
            <td>{{ $ss->currSurveyDate }}</td>
        @endif
		@if (Storage::exists($ss->currSurveyReport))
            <td>{{ $ss->currSurveyID}}
                <a href="{{ Storage::url($ss->currSurveyReport) }}" target="_blank" title="Survey report" alt="Survey report">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </a>
            </td>
		@else
            <td>{{ $ss->currSurveyID }}</td>
		@endif
		</tr>
@endforeach
	</tbody>
</table>
