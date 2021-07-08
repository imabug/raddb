<h2><span class="label label-default">Pending surveys</span></h2>
<table class="table table-striped table-hover table-sm">
	<thead>
		<tr>
			<th scope="col">Survey ID</th>
            <th scope="col">Description</th>
            <th scope="col">Date Scheduled</th>
            <th scope="col">Test type</th>
            <th scope="col">Accession</th>
            <th scope="col">Survey Note</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
@foreach ($pendingSurveys as $pending)
    @unless (is_null($pending->machine))
 		<tr>
			<th scope="row"><a href="{{ route('surveys.edit', $pending->id)}}">{{ $pending->id }}</a></th>
			<td><a href="{{ route('machines.show', $pending->machine->id) }}">{{ $pending->machine->description }}</a></td>
			<td>{{ $pending->test_date}}</td>
            <td>{{ $pending->type->test_type}}</td>
			<td>{{ $pending->accession }}</td>
			<td>{{ $pending->notes }}</td>
            <td><a href="{{ route('surveys.edit', $pending->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            </td>
		</tr>
    @endunless
@endforeach
	</tbody>
</table>
