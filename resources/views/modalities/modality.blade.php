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
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($machines as $machine)
        <tr>
            <td>{{ $machine->id }}</td>
            <td><a href="{{ route('manufacturers.showManufacturer', $machine->manufacturer_id) }}">{{ $machine->manufacturer->manufacturer }}</a></td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td><a href="/machines/{{ $machine->id }}">{{ $machine->description }}</a></td>
            <td><a href="/locations/{{$machine->location_id}}">{{ $machine->location->location }}</a></td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>
            <td>
                <form class="form-inline" action="/machines/{{ $machine->id }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <a href="/machines/{{ $machine->id }}/edit" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this machine">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
