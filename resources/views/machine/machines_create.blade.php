<!-- resources/views/machine/machines_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a machine</h2>

<form class="form-inline" action="/machines" method="POST">
	<div class="form-group">

		{{ csrf_field() }}
		<p><label for="modality">Modality:</label>
		<select id="modality" name="modality" size="1">
			<option>Select modality</option>

		@foreach ($modalities as $modality)
		<option value="{{ $modality->id }}">{{ $modality->modality }}</option>
		@endforeach

		</select></p>
		<p><label for="description">Description:</label>	<input type="text" name="description" size="40" /></p>
		<p><label for="manufacturer">Manufacturer:</label>
		<select id="manufacturer" name="manufacturer" size="1">
			<option>Select manufacturer</option>

		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
		@endforeach

		</select></p>
		<p><label for="model">Model:</label> <input type="text" id="model" name="model" size="20" /></p>
		<p><label for="serialNumber">Serial Number:</label> <input type="text" id="serialNumber" name="serialNumber" size="20" /></p>
		<p><label for="vendSiteID">Vendor site ID:</label> <input type="text" id="vendSiteID" name="vendSiteID" size="20" /></p>
		<p><label for="manufDate">Manufacture date:</label> <input type="text" id="manufDate" name="manufDate" size="10" /> (YYYY-MM-DD)</p>
		<p><label for="installDate">Install date:</label> <input type="text" id="installDate" name="installDate" size="10" /> (YYYY-MM-DD)</p>
		<p><label for="location">Location:</label>
		<select id="location" name="location" size="1">
			<option>Select location</option>

		@foreach ($locations as $location)
		<option value="{{ $location->id }}">{{ $location->location }}</option>
		@endforeach

		</select></p>
		<p><label for="room">Room:</label> <input type="text" id="room" name="room" size="20" /></p>
		<p><label for="status">Machine status:</label>
		<select id="status" name="status" size="1">
			<option>Select status</option>
			<option value="Active" selected="selected">Active</option>
			<option value="Inactive">Inactive</option>
			<option value="Removed">Removed</option>
		</select></p>
		<p><label for="notes">Notes:</label><br /> <textarea id="notes" name="notes" rows="3" cols="70">Enter any notes about the machine here</textarea></p>

		<p><button type="SUBMIT">Add machine</button> / <a href="/">Main</a></p>

	</div>
</form>


@endsection
