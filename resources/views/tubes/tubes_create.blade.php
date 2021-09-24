<!-- resources/views/tubes/tubes_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a tube</h2>
<p>
<form class="form-inline" action="{{ route('tubes.store') }}" method="POST">
{{ csrf_field() }}
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Machine:</span>
         <select class="form-control" id="machine_id" name="machine_id" size="1" aria-label="Select machine (required)">
           <option>Select machine</option>

     @foreach ($machines as $machine)
           <option value="{{ $machine->id}}"
     @if ($machine->id == $machineID)
             selected="selected"
     @endif
           >{{ $machine->description }}</option>
         @endforeach
         </select> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Housing Manufacturer:</span>
         <select class="form-control" id="hsgManufID" name="hsgManufID" size="1" aria-label="Enter x-ray tube housing manufacturer">
           <option>Select manufacturer</option>

     @foreach ($manufacturers as $manufacturer)
           <option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
         @endforeach

         </select>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Housing Model:</span>
         <input class="form-control" type="TEXT" id="hsgModel" name="hsgModel" size="50" aria-label="Enter x-ray tube housing model">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Housing SN:</span>
         <input class="form-control" type="TEXT" id="hsgSN" name="hsgSN" size="20" aria-label="Enter x-ray tube housing serial number">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Insert Manufacturer:</span>
         <select class="form-control" id="insertManufID" name="insertManufID" size="1" aria-label="Enter x-ray tube manufacturer">
           <option>Select manufacturer</option>

     @foreach ($manufacturers as $manufacturer)
           <option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
         @endforeach

         </select>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Insert Model:</span>
         <input class="form-control" type="text" id="insertModel" name="insertModel" size="50" aria-label="Enter x-ray tube insert model">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Insert SN:</span>
         <input class="form-control" type="text" id="insertSN" name="insertSN" size="20" aria-label="Enter x-ray tube insert serial number">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Manufacture Date:</span>
         <input class="form-control" type="date" id="manufDate" name="manufDate" size="10" aria-label="Enter x-ray tube manufacture date">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Install date:</span>
         <input class="form-control" type="date" id="installDate" name="installDate" size="10" aria-label="Enter x-ray tube install date">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Large FS (mm):</span>
         <input class="form-control" type="text" id="lfs" name="lfs" size="4" value="0" aria-label="Enter large focal spot size (mm)">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Medium FS (mm):</span>
         <input class="form-control" type="text" id="mfs" name="mfs" size="4" value="0" aria-label="Enter medium focal spot size (mm)">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Small FS (mm):</span>
         <input class="form-control" type="text" id="sfs" name="sfs" size="4" value="0" aria-label="Enter small focal spot size (mm)">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Notes</span>
         <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Additional notes about this tube" aria-label="Enter notes about the x-ray tube"></textarea>
       </div>
     </div>
	 <button class="btn btn-primary" type="SUBMIT">Add tube</button>
</form>
</p>
<p><span class="text-danger">*</span> Required field</p>
@endsection
