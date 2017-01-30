<!-- resources/views/tubes/tubes_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a tube</h2>
<p>
<form class="form-inline" action="{{route('tubes.update', $tube->id)}}" method="POST">
    <div class="form-group">
    	{{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" id="machine_id" name="machine_id" value="{{ $machine->id }}" >
        <input type="hidden" id="tube_id" name="tube_id" value="{{$tube->id}}">
    <p><label for="machine">Machine:</label> {{ $machine->description }}</p>
    <p><label for="hsgManufID">Housing Manufacturer:</label>
    	<select class="form-control" id="hsgManufID" name="hsgManufID" size="1">
    	<option>Select manufacturer</option>
    	@foreach ($manufacturers as $manufacturer)
    	<option value="{{ $manufacturer->id }}"
@if ($manufacturer->id == $tube->housing_manuf_id)
    selected="selected"
@endif
            >{{ $manufacturer->manufacturer }}</option>
    	@endforeach
    	</select></p>
    <p><label for="hsgModel">Housing Model:</label> <input class="form-control" type="TEXT" id="hsgModel" name="hsgModel" size="20" value="{{ $tube->housing_model }}" ></p>
    <p><label for="hsgSN">Housing SN:</label> <input class="form-control" type="TEXT" id="hsgSN" name="hsgSN" size="20" value="{{ $tube->housing_sn }}" ></p>
    <p><label for="insertManufID">Insert Manufacturer:</label>
    	<select class="form-control" id="insertManufID" name="insertManufID" size="1">
    	<option>Select manufacturer</option>
    	@foreach ($manufacturers as $manufacturer)
    	<option value="{{ $manufacturer->id }}"
@if ($manufacturer->id == $tube->insert_manuf_id)
    selected="selected"
@endif
            >{{ $manufacturer->manufacturer }}</option>
    	@endforeach
    	</select></p>
    <p><label for="insertModel">Insert Model:</label> <input class="form-control" type="text" id="insertModel" name="insertModel" size="20" value="{{ $tube->insert_model }}" ></p>
    <p><label for="insertSN">Insert SN:</label> <input class="form-control" type="text" id="insertSN" name="insertSN" size="20" value="{{ $tube->insert_sn }}" ></p>
    <p><label for="manufDate">Manufacture Date:</label> <input class="form-control" type="date" id="manufDate" name="manufDate" size="10" value="{{ $tube->manuf_date }}" ></p>
    <p><label for="installDate">Install date:</label> <input class="form-control" type="date" id="installDate" name="installDate" size="10" value="{{ $tube->install_date }}" ></p>
    <p><label for="lfs">Focal spot size: Large:</label> <input class="form-control" type="text" id="lfs" name="lfs" size="4" value="{{ $tube->lfs }}" >mm
    	<label for="mfs">Medium:</label> <input class="form-control" type="text" id="mfs" name="mfs" size="4" value="{{ $tube->mfs }}" >mm
    	<label for="sfs">Small:</label> <input class="form-control" type="text" id="sfs" name="sfs" size="4" value="{{ $tube->sfs }}" >mm</p>
    <p><label for="notes">Notes</label><br /><textarea class="form-control" id="notes" name="notes" rows="3" cols="70">{{$tube->notes}} </textarea></p>
    <p><button type="SUBMIT">Modify tube</button> / <a href="/">Main</a></p>
    </div>
</form>
</p>
@endsection
