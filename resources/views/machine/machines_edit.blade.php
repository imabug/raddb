<!-- resources/views/machine/machines_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a machine</h2>

<form class="form-inline" action="/machines/{{ $machine->id }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<p><label for="modality_id">Modality:</label>
		<select class="form-control" id="modality_id" name="modality_id" size="1">
			<option>Select modality</option>

		@foreach ($modalities as $modality)
		<option value="{{ $modality->id }}"
			@if ($modality->id == $machine->modality_id)
				selected="selected"
			@endif
			>{{ $modality->modality }}</option>
		@endforeach

		</select></p>
		<p><label for="description">Description:</label> <input class="form-control" type="text" id="description" name="description" size="40" value="{{ $machine->description }}" /></p>
		<p><label for="manufacturer">Manufacturer:</label>
		<select class="form-control" id="manufacturer_id" name="manufacturer_id" size="1">
			<option>Select manufacturer</option>

		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}"
			@if ($manufacturer->id == $machine->manufacturer_id)
				selected="selected"
			@endif
			>{{ $manufacturer->manufacturer }}</option>
		@endforeach

		</select></p>
		<p><label for="model">Model:</label> <input class="form-control" type="text" id="model" name="model" size="20" value="{{ $machine->model }}"/></p>
		<p><label for="serialNumber">Serial Number:</label> <input class="form-control" type="text" id="serialNumber" name="serialNumber" size="20" value="{{ $machine->serial_number }}"/></p>
		<p><label for="vendSiteID">Vendor site ID:</label> <input class="form-control" type="text" id="vendSiteID" name="vendSiteID" size="20"  value="{{ $machine->vend_site_id }}"/></p>
		<p><label for="manufDate">Manufacture date:</label> <input class="form-control" type="text" id="manufDate" name="manufDate" size="20" value="{{ $machine->manuf_date }}"/> (YYYY-MM-DD)</p>
		<p><label for="installDate">Install date:</label> <input class="form-control" type="text" id="installDate" name="installDate" size="20" value="{{ $machine->install_date }}"/> (YYYY-MM-DD)</p>
		<p><label for="location">Location:</label>
		<select class="form-control" id="location_id" name="location_id" size="1">
			<option>Select location</option>

		@foreach ($locations as $location)
		<option value="{{ $location->id }}"
			@if ($location->id == $machine->location_id)
				selected="selected"
			@endif
			>{{ $location->location }}</option>
		@endforeach
		</select></p>
		<p><label for="room">Room:</label> <input type="text" id="room" name="room" size="20" value="{{ $machine->room }}"/></p>
		<p><label for="status">Machine status:</label>
		<select class="form-control" id="status" name="status" size="1">
			<option>Select status</option>
			<option value="Active" selected="selected">Active</option>
			<option value="Inactive">Inactive</option>
			<option value="Removed">Removed</option>
		</select></p>
		<p><label for="notes">Notes:</label><br /> <textarea id="notes" name="notes" rows="3" cols="70">{{ $machine->notes }}</textarea></p>

		<p><button type="SUBMIT">Edit machine</button> / <a href="/">Main</a></p>

	</div>
</form>


@endsection
