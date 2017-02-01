<!-- resources/views/tubes/tubes_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a tube</h2>
<p>
<form class="form-inline" action="{{ route('tubes.store') }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
	<p><label for="machine">Machine:</label>
		<select id="machine_id" name="machine_id" size="1">
		<option>Select machine</option>

		@foreach ($machines as $machine)
		<option value="{{ $machine->id}}"
			@if ($machine->id == $machineID)
			selected="selected"
			@endif
			>{{ $machine->description }}</option>
		@endforeach
		</select></p>
	<p><label for="hsgManufID">Housing Manufacturer:</label>
		<select id="hsgManufID" name="hsgManufID" size="1">
		<option>Select manufacturer</option>

		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
		@endforeach

		</select></p>
	<p><label for="hsgModel">Housing Model:</label> <input type="TEXT" id="hsgModel" name="hsgModel" size="20"></p>
	<p><label for="hsgSN">Housing SN:</label> <input type="TEXT" id="hsgSN" name="hsgSN" size="20"></p>
	<p><label for="insertManufID">Insert Manufacturer:</label>
		<select id="insertManufID" name="insertManufID" size="1">
		<option>Select manufacturer</option>

		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
		@endforeach

		</select></p>
	<p><label for="insertModel">Insert Model:</label> <input type="text" id="insertModel" name="insertModel" size="20" ></p>
	<p><label for="insertSN">Insert SN:</label> <input type="text" id="insertSN" name="insertSN" size="20" ></p>
	<p><label for="manufDate">Manufacture Date:</label> <input type="date" id="manufDate" name="manufDate" size="10" ></p>
	<p><label for="installDate">Install date:</label> <input type="date" id="installDate" name="installDate" size="10" ></p>
	<p><label for="lfs">Focal spot size: Large:</label> <input type="text" id="lfs" name="lfs" size="4" />mm
    	<label for="mfs">Medium:</label> <input type="text" id="mfs" name="mfs" size="4" >mm
		<label for="sfs">Small:</label> <input type="text" id="sfs" name="sfs" size="4" >mm</p>
	<p><label for="notes">Notes</label><br /><textarea id="notes" name="notes" rows="3" cols="70" placeholder="Additional notes about this tube"></textarea></p>
	<p><button type="SUBMIT">Add tube</button></p>
	</div>
</form>
</p>
@endsection
