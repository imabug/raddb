<!-- resources/views/machine/machines_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a machine</h2>

<form class="form-inline" action="{{ route('machines.update', $machine->id) }}" method="POST">
{{ csrf_field() }}
{{ method_field('PUT') }}
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Modality:</span>
         <select class="form-control" id="modality" name="modality" size="1" aria-label="Select modality (required)">
           <option>Select modality</option>
@foreach ($modalities as $modality)
           <option value="{{ $modality->id }}"
@if ($modality->id == $machine->modality_id)
             selected
@endif
           >{{ $modality->modality }}</option>
@endforeach
         </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Description:</span>
         <input class="form-control" type="text" id="description" name="description" size="40" value="{{ $machine->description }}" aria-label="Enter description"> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Machine status:</label>
         <select class="form-control" id="status" name="status" size="1" aria-label="Select machine status">
@if ($machine->machine_status == "Active")
           <option value="Active" selected>Active</option>
@else
           <option value="Active">Active</option>
@endif
@if ($machine->machine_status == "Inactive")
           <option value="Inactive" selected>Inactive</option>
@else
           <option value="Inactive">Inactive</option>
@endif
@if ($machine->machine_status == "Removed")
           <option value="Removed" selected>Removed</option>
@else
           <option value="Removed">Removed</option>
@endif
         </select> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Manufacturer:</span>
         <select class="form-control" id="manufacturer" name="manufacturer" size="1" aria-label="Select machine manufacturer">
           <option>Select manufacturer</option>
@foreach ($manufacturers as $manufacturer)
           <option value="{{ $manufacturer->id }}"
@if ($manufacturer->id == $machine->manufacturer_id)
             selected
@endif
           >{{ $manufacturer->manufacturer }}</option>
@endforeach

         </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Model:</span>
         <input class="form-control" type="text" id="model" name="model" size="20" value="{{ $machine->model }}" aria-label="Enter model"> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Serial Number:</span>
         <input class="form-control" type="text" id="serialNumber" name="serialNumber" size="20" value="{{ $machine->serial_number }}" aria-label="Enter machine serial number"> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Software version:</span>
         <input class="form-control" type="text" id="softwareVersion" name="softwareVersion" size="50" value="{{ $machine->software_version }}" aria-label="Enter software version">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Vendor site ID:</span>
         <input class="form-control" type="text" id="vendSiteID" name="vendSiteID" size="20"  value="{{ $machine->vend_site_id }}" aria-label="Enter vendor site ID">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Manufacture date:</span>
         <input class="form-control" type="date" id="manufDate" name="manufDate" size="20" value="{{ $machine->manuf_date }}" aria-label="Enter manufacture date">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Install date:</span>
         <input class="form-control" type="date" id="installDate" name="installDate" size="20" value="{{ $machine->install_date }}"  aria-label="Enter installation date">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Location:</span>
         <select class="form-control" id="location" name="location" size="1" aria-label="Select location">
           <option>Select location</option>
@foreach ($locations as $location)
           <option value="{{ $location->id }}"
@if ($location->id == $machine->location_id)
             selected
@endif
           >{{ $location->location }}</option>
@endforeach
         </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Room:</span>
         <input type="text" id="room" name="room" size="20" value="{{ $machine->room }}" aria-label="Enter room number"> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Notes:</span>
         <textarea id="notes" name="notes" rows="3" cols="70" aria-label="Enter notes about the machine">{{ $machine->notes }}</textarea>
       </div>
     </div>

	<button class="btn btn-primary" type="SUBMIT">Edit machine</button>
</form>
<p> <span class="text-danger">*</span> Required field</p>

@endsection
