<!-- resources/views/testequipment/show_cal_dates.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Recent Test Equipment Calibration Dates</h2>
<table class="table table-striped table-hover table-sm">
	<thead>
		<tr>
     <th scope="col">ID</th>
     <th scope="col">Manufacturer</th>
     <th scope="col">Model</th>
     <th scope="col">SN</th>
     <th scope="col">Description</th>
     <th scope="col">Location</th>
     <th scope="col">Age</th>
     <th scope="col">Room</th>
     <th scope="col">Last calibration</th>
		</tr>
	</thead>
	<tbody>

    @foreach ($testequipment as $t)
        <tr>
            <th scope="row">{{ $t->id }}</th>
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
