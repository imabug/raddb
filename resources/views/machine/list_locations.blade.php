<!-- resources/views/machine/list_locations.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory</h2>
<h3>List equipment by location</h3>
    @foreach ($machines as $location)
<h4>Location: ({{ count($location) }})</h4>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>SN</th>
            <th>Description</th>
            <th>Modality</th>
            <th>Location</th>
            <th>Age</th>
            <th>Room</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($location as $machine)
        <tr>
            <td>{{ $machine->id }}</td>
            <td>{{ $machine->manufacturer->manufacturer }}</td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td><a href="/machines/{{ $machine->id }}">{{ $machine->description }}</a></td>
            <td>{{ $machine->modality->modality }}</td>
            <td>{{ $machine->location->location }}</td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
    @endforeach
@endsection
