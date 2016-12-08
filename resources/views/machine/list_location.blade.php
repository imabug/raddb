<!-- resources/views/machine/location_list.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory</h2>
<h3>List equipment by location</h3>

<h3>{{ $location->location }} ({{ $n }} units)</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>SN</th>
            <th>Description</th>
            <th>Modality</th>
            <th>Age</th>
            <th>Room</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($machines as $machine)
        <tr>
            <td>{{ $machine->id }}</td>
            <td>{{ $machine->manufacturer->manufacturer }}</td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td><a href="/machines/{{ $machine->id }}">{{ $machine->description }}</a></td>
            <td><a href="/machines/modalities/{{ $machine->modality_id }}">{{ $machine->modality->modality }}</a></td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
