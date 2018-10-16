<!-- resources/views/machine/tubes.blade.php -->

<h3><span class="label label-default">Tube Information</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Tube ID</th>
            <th>Housing</th>
            <th>Housing SN</th>
            <th>Insert</th>
            <th>Insert SN</th>
            <th>Focal Spots</th>
            <th>Manuf Date</th>
            <th>Age</th>
            <th>Status</th>
            <th>Notes</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tubes as $tube)
        <tr>
            <td>{{ $tube->id }}</td>
            <td>{{ $tube->housing_manuf->manufacturer }} {{ $tube->housing_model }}</td>
            <td>{{ $tube->housing_sn }}</td>
            <td>{{ $tube->insert_manuf->manufacturer }} {{ $tube->insert_model }}</td>
            <td>{{ $tube->insert_sn }}</td>
            <td>{{ $tube->lfs }} / {{ $tube->mfs }} / {{ $tube->sfs }}</td>
            <td>{{ $tube->manuf_date }}</td>
            <td>{{ $tube->age }}</td>
            <td>{{ $tube->tube_status }}</td>
            <td>{{ $tube->notes }}</td>
			<td>
                @if (Auth::check())
				<form class="form-inline" action="{{ route('tubes.destroy', $tube->id) }}" method="post">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<div class="form-group">
                        <a href="{{ route('tubes.edit', $tube->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this tube">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
						<button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this tube">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
				</form>
                @endif
			</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (Auth::check())
<p><a href="{{ route('tubes.createTubeFor', $machine->id) }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add x-ray tube</a></p>
@endif
