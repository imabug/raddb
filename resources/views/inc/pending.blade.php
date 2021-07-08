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
     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
     <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
     </svg></a>
            </td>
		</tr>
    @endunless
@endforeach
	</tbody>
</table>
