<!-- resources/views/machine/list_locations.blade.php -->

@extends('layouts.app')

@section('content')
{!! Charts::assets(['google']) !!}
<h2>Equipment Inventory</h2>
<h3>List equipment by manufacturer</h3>
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $machinesManufChart->render() !!}</p>
    </div>
</div>
    @foreach ($machines as $key=>$manufacturer)
<h4>Manufacturer: {{ $key }} ({{ count($manufacturer) }})</h4>
<table class="table table-striped table-hover">
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
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($manufacturer as $machine)
        <tr>
            <td>{{ $machine->id }}</td>
            <td><a href="{{ route('machines.showManufacturer', $machine->manufacturer_id) }}">{{ $machine->manufacturer->manufacturer }}</a></td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td><a href="{{ route('machines.show', $machine->id) }}">{{ $machine->description }}</a></td>
            <td><a href="{{ route('machines.showModality', $machine->modality_id) }}">{{ $machine->modality->modality }}</a></td>
            <td><a href="{{ route('machines.showLocation', $machine->location_id) }}">{{ $machine->location->location }}</a></td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>
            <td>
                @if (Auth::check())
                <form class="form-inline" action="{{ route('machines.destroy', $machine->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <a href="{{ route('machines.edit', $machine->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this machine">
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
    @endforeach
@endsection
