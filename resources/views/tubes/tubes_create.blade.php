<!-- resources/views/tubes/tubes_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a tube</h2>

<form action="/tubes" method="POST">
	{{ csrf_field() }}
<p><label>Machine:</label>
	<select name="machine" size="1">
	<option>Select machine</option>

	@foreach ($machines as $machine)
	<option value="{{ $machine->id}}"
		@if ($machine->id == $machineID)
		selected="selected"
		@endif
		>{{ $machine->description }}</option>
	@endforeach
	</select></p>
<p><label>Housing Manufacturer:</label>
	<select name="hsgManufID" size="1">
	<option>Select manufacturer</option>

	@foreach ($manufacturers as $manufacturer)
	<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
	@endforeach

	</select></p>
<p><label>Housing Model:</label> <input type="TEXT" name="hsgModel" size="20"></p>
<p><label>Housing SN:</label> <input type="TEXT" name="hsgSN" size="20"></p>
<p><label>Insert Manufacturer:</label>
	<select name="insertManufID" size="1">
	<option>Select manufacturer</option>

	@foreach ($manufacturers as $manufacturer)
	<option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
	@endforeach

	</select></p>
<p><label>Insert Model:</label> <input type="text" name="insertModel" size="20" /></p>
<p><label>Insert SN:</label> <input type="text" name="insertSN" size="20" /></p>
<p><label>Manufacture Date:</label> <input type="text" name="manufDate" size="10" /> (YYYY-MM-DD)</p>
<p><label>Install date:</label> <input type="text" name="installDate" size="10" /> (YYYY-MM-DD)</p>
<p><label>Focal spot size: Large:</label> <input type="text" name="lfs" size="4" />mm
	<label>Medium:</label> <input type="text" name="mfs" size="4" />mm
	<label>Small:</label> <input type="text" name="sfs" size="4" />mm</p>
<p><label>Notes</label><br /><textarea name="notes" rows="3" cols="70">Additional notes about this tube</textarea></p>
<p><button type="SUBMIT">Add tube</button> / <a href="/">Main</a></p>
</form>

@endsection
