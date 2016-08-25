<!-- resources/views/machine/machines_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a machine</h2>

<form action="/machines/{{ $machine->id }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<p><label>Modality:</label>
	<select name="modality" size="1">
		<option>Select modality</option>

	@foreach ($modalities as $modality)
	<option value="{{ $modality->id }}"
		@if ($modality->id == $machine->modality_id)
			selected="selected"
		@endif
		>{{ $modality->modality }}</option>
	@endforeach

	</select></p>
	<p><label>Description:</label>	<input type="text" name="description" size="40" value="{{ $machine->description }}" /></p>
	<p><label>Manufacturer:</label>
	<select name="manufacturer" size="1">
		<option>Select manufacturer</option>

	@foreach ($manufacturers as $manufacturer)
	<option value="{{ $manufacturer->id }}"
		@if ($manufacturer->id == $machine->manufacturer_id)
			selected="selected"
		@endif
		>{{ $manufacturer->manufacturer }}</option>
	@endforeach

	</select></p>
	<p><label>Model:</label> <input type="text" name="model" size="20" value="{{ $machine->model }}"/></p>
	<p><label>Serial Number:</label> <input type="text" name="serialNumber" size="20" value="{{ $machine->serial_number }}"/></p>
	<p><label>Vendor site ID:</label> <input type="text" name="vendSiteID" size="20"  value="{{ $machine->vend_site_id }}"/></p>
	<p><label>Manufacture date:</label> <input type="text" name="manufDate" size="20" value="{{ $machine->manuf_date }}"/> (YYYY-MM-DD)</p>
	<p><label>Install date:</label> <input type="text" name="installDate" size="20" value="{{ $machine->install_date }}"/> (YYYY-MM-DD)</p>
	<p><label>Location:</label>
	<select name="location" size="1">
		<option>Select location</option>

	@foreach ($locations as $location)
	<option value="{{ $location->id }}"
		@if ($location->id == $machine->location_id)
			selected="selected"
		@endif
		>{{ $location->location }}</option>
	@endforeach

	</select></p>
	<p><label>Room:</label> <input type="text" name="room" size="20" value="{{ $machine->room }}"/></p>
	<p><label>Machine status:</label>
	<select name="status" size="1">
		<option>Select status</option>
		<option value="Active" selected="selected">Active</option>
		<option value="Inactive">Inactive</option>
		<option value="Removed">Removed</option>
	</select></p>
	<p><label>Notes:</label><br /> <textarea name="notes" rows="3" cols="70">{{ $machine->notes }}</textarea></p>

	<p><button type="SUBMIT">Edit machine</button> / <a href="/">Main</a></p>

</form>


@endsection
