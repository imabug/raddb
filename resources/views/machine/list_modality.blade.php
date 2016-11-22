<!-- resources/views/machine/modality_list.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory</h2>
<h3>List equipment by modality</h3>
<h3>{{ $modality->modality }} ({{ $n }} units)</h3>
<table class="table">
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
        </tr>
    </thead>
    <tbody>
    @foreach ($machines as $machine)
        <tr>
            <td>{{ $machine->id }}</td>
            <td>{{ $machine->manufacturer->manufacturer }}</td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td>{{ $machine->description }}</td>
            <td>{{ $machine->location->location }}</td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
