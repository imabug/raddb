<h2><span class="label label-default">Pending surveys</span></h2>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Survey ID</th>
            <th>Description</th>
            <th>Date Scheduled</th>
            <th>Test type</th>
            <th>Accession</th>
            <th>Survey Note</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
@foreach ($pendingSurveys as $pending)
		<tr>
			<td><a href="{{ route('surveys.edit', $pending->surveyId)}}">{{ $pending->surveyId }}</a></td>
			<td><a href="{{ route('machines.show', $pending->machineId) }}">{{ $pending->description }}</a></td>
			<td>{{ $pending->test_date}}</td>
            <td>{{ $pending->type->test_type}}</td>
			<td>{{ $pending->accession }}</td>
			<td>{{ $pending->notes }}</td>
            <td><a href="{{ route('surveys.edit', $pending->surveyId) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            </td>
		</tr>
@endforeach
	</tbody>
</table>
