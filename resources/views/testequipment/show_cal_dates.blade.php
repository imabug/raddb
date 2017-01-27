<!-- resources/views/testequipment/show_cal_dates.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Recent Test Equipment Calibration Dates</h2>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Manufacturer</th>
			<th>Model</th>
			<th>SN</th>
			<th>Description</th>
			<th>Location</th>
	        <th>Age</th>
			<th>Room</th>
			<th>Last calibration</th>
		</tr>
	</thead>
	<tbody>

    @foreach ($testequipment as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->manufacturer->manufacturer }}</td>
            <td>{{ $t->model }}</td>
            <td>{{ $t->serial_number }}</td>
            <td>{{ $t->description }}</td>
            <td>{{ $t->location->location }}</td>
            <td>{{ $t->age }}</td>
            <td>{{ $t->room }}</td>
            @foreach ($t->testdate as $td)
            @if($loop->first)
            <td>{{ $td->test_date }}</td>
            @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
