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
    if (is_null($pending->machine)) {
        break;
    }
    else {
		<tr>
			<td><a href="{{ route('surveys.edit', $pending->id)}}">{{ $pending->id }}</a></td>
			<td><a href="{{ route('machines.show', $pending->machine->id) }}">{{ $pending->machine->description }}</a></td>
			<td>{{ $pending->test_date}}</td>
            <td>{{ $pending->type->test_type}}</td>
			<td>{{ $pending->accession }}</td>
			<td>{{ $pending->notes }}</td>
            <td><a href="{{ route('surveys.edit', $pending->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            </td>
		</tr>
    }
@endforeach
	</tbody>
</table>
