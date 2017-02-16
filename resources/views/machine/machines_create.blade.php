<!-- resources/views/machine/machines_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a machine</h2>

<form class="form-inline" action="{{route('machines.store')}}" method="POST">
	<div class="form-group">

		{{ csrf_field() }}
		<p><label for="modality">Modality:</label>
		<select id="modality" name="modality" size="1" class="form-control" autofocus>
			<option>Select modality</option>

		@foreach ($modalities as $modality)
		<option value="{{ $modality->id }}">{{ $modality->modality }}</option>
		@endforeach

        </select> <span class="text-danger">*</span></p>
		<p><label for="description">Description:</label>	<input type="text" class="form-control" name="description" size="40" > <span class="text-danger">*</span></p>
		<p><label for="manufacturer">Manufacturer:</label>
		<select class="form-control" id="manufacturer" name="manufacturer" size="1">
			<option>Select manufacturer</option>

		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
		@endforeach

		</select> <span class="text-danger">*</span></p>
		<p><label for="model">Model:</label> <input class="form-control" type="text" id="model" name="model" size="20" > <span class="text-danger">*</span></p>
		<p><label for="serialNumber">Serial Number:</label> <input class="form-control" type="text" id="serialNumber" name="serialNumber" size="20" > <span class="text-danger">*</span></p>
		<p><label for="vendSiteID">Vendor site ID:</label> <input class="form-control" type="text" id="vendSiteID" name="vendSiteID" size="20" ></p>
		<p><label for="manufDate">Manufacture date:</label> <input class="form-control" type="date" id="manufDate" name="manufDate" size="10"></p>
		<p><label for="installDate">Install date:</label> <input class="form-control" type="date" id="installDate" name="installDate" size="10"></p>
		<p><label for="location">Location:</label>
		<select class="form-control" id="location" name="location" size="1">
			<option>Select location</option>

		@foreach ($locations as $location)
		<option value="{{ $location->id }}">{{ $location->location }}</option>
		@endforeach

		</select> <span class="text-danger">*</span></p>
		<p><label for="room">Room:</label> <input class="form-control" type="text" id="room" name="room" size="20" > <span class="text-danger">*</span></p>
		<p><label for="status">Machine status:</label>
		<select class="form-control" id="status" name="status" size="1">
			<option>Select status</option>
			<option value="Active" selected="selected">Active</option>
			<option value="Inactive">Inactive</option>
			<option value="Removed">Removed</option>
		</select> <span class="text-danger">*</span></p>
		<p><label for="notes">Notes:</label><br /> <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Enter any notes about the machine here"></textarea></p>

		<p><button class="form-control" type="SUBMIT">Add machine</button></p>
	</div>
</form>
<p><span class="text-danger">*</span> Required field</p>
@endsection
