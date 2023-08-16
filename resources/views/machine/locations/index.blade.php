<!-- resources/views/machine/locations/index.blade.php -->

@extends('layouts.app')

@section('content')
  <h2>Equipment Inventory</h2>
  <h3>List equipment by location</h3>
  @foreach ($machines as $key=>$location)
    <h4>Location: {{ $key }} ({{ count($location) }})</h4>
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Manufacturer</th>
          <th scope="col">Model</th>
          <th scope="col">SN</th>
          <th scope="col">Description</th>
          <th scope="col">Modality</th>
          <th scope="col">Location</th>
          <th scope="col">Age</th>
          <th scope="col">Room</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($location as $machine)
          <tr>
            <th scope="row">{{ $machine->id }}</th>
            <td><a href="{{ route('machines.showManufacturer', $machine->manufacturer_id) }}">{{ $machine->manufacturer->manufacturer }}</a></td>
            <td>{{ $machine->model }}</td>
            <td>{{ $machine->serial_number }}</td>
            <td><a href="{{ route('machines.show', $machine->id) }}">{{ $machine->description }}</a></td>
            <td><a href="{{ route('machines.showModality', $machine->modality_id) }}">{{ $machine->modality->modality }}</a></td>
            <td><a href="{{ route('machines.showLocation', $machine->location_id) }}">{{ $machine->location->location }}</a></td>
            <td>{{ $machine->age }}</td>
            <td>{{ $machine->room }}</td>
            <td>
			  <form class="row gy-1 gx-2 align-items-center" action="{{ route('machines.destroy', $machine->id) }}" method="post">
                @csrf
                @method('DELETE')
				<div class="col-auto">
                  <a href="{{ route('machines.edit', $machine->id) }}" data-toggle="tooltip" title="Modify this machine">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this machine">
                      <x-glyphs.pencil />
                    </button>
                  </a>
                  <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove this machine">
                    <x-glyphs.trashcan />
                  </button>
				</div>
			  </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endforeach
@endsection
