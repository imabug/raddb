<!-- resources/views/machine/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory</h2>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
	        <th>Modality</th>
			<th>Manufacturer</th>
			<th>Model</th>
			<th>SN</th>
			<th>Description</th>
			<th>Location</th>
	        <th>Age</th>
			<th>Room</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($machines as $machine)
		<tr>
			<td>{{ $machine->id }}</td>
	        <td>{{ $machine->modality->modality }}</td>
			<td>{{ $machine->manufacturer->manufacturer }}</td>
			<td>{{ $machine->model }}</td>
			<td>{{ $machine->serial_number }}</td>
			<td><a href="/machines/{{ $machine->id }}">{{ $machine->description }}</a></td>
			<td>{{ $machine->location->location }}</td>
	        <td>{{ $machine->age }}</td>
			<td>{{ $machine->room }}</td>
			<td>
				<form class="form-inline" action="/machines/{{ $machine->id }}" method="post">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit" class="btn btn-xs">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection
