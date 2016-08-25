<!-- resources/views/machine/machines_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a machine</h2>

<form action="/machines" method="POST">
	{{ csrf_field() }}
	<p><label>Modality:</label>
	<select name="modality" size="1">
		<option>Select modality</option>

	@foreach ($modalities as $modality)
	<option value="{{ $modality->id }}">{{ $modality->modality }}</option>
	@endforeach

	</select></p>
	<p><label>Description:</label>	<input type="text" name="description" size="40" /></p>
	<p><label>Manufacturer:</label>
	<select name="manufacturer" size="1">
		<option>Select manufacturer</option>

	@foreach ($manufacturers as $manufacturer)
	<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
	@endforeach

	</select></p>
	<p><label>Model:</label> <input type="text" name="model" size="20" /></p>
	<p><label>Serial Number:</label> <input type="text" name="serialNumber" size="20" /></p>
	<p><label>Vendor site ID:</label> <input type="text" name="vendSiteID" size="20" /></p>
	<p><label>Manufacture date:</label> <input type="text" name="manufDate" size="10" /> (YYYY-MM-DD)</p>
	<p><label>Install date:</label> <input type="text" name="installDate" size="10" /> (YYYY-MM-DD)</p>
	<p><label>Location:</label>
	<select name="location" size="1">
		<option>Select location</option>

	@foreach ($locations as $location)
	<option value="{{ $location->id }}">{{ $location->location }}</option>
	@endforeach

	</select></p>
	<p><label>Room:</label> <input type="text" name="room" size="20" /></p>
	<p><label>Machine status:</label>
	<select name="status" size="1">
		<option>Select status</option>
		<option value="Active" selected="selected">Active</option>
		<option value="Inactive">Inactive</option>
		<option value="Removed">Removed</option>
	</select></p>
	<p><label>Notes:</label><br /> <textarea name="notes" rows="3" cols="70">Enter any notes about the machine here</textarea></p>

	<p><button type="SUBMIT">Add machine</button> / <a href="/">Main</a></p>

</form>


@endsection
