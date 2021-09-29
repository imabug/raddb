<!-- resources/views/machine/machines_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a machine</h2>

<form class="form-inline" action="{{route('machines.store')}}" method="POST">
@csrf
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Modality:</span>
           <select id="modality" name="modality" size="1" class="form-select" autofocus aria-label="Select modality (required)">
             <option>Select modality</option>

     @foreach ($modalities as $modality)
             <option value="{{ $modality->id }}">{{ $modality->modality }}</option>
     @endforeach
           </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Description:</span>
         <input type="text" class="form-control" name="description" size="40" aria-label="Enter machine description (required)"> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Machine status:</span>
         <select class="form-select" id="status" name="status" size="1" aria-label="Select machine status (required)">
           <option>Select status</option>
           <option value="Active" selected="selected">Active</option>
           <option value="Inactive">Inactive</option>
           <option value="Removed">Removed</option>
         </select> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Manufacturer:</span>
         <select class="form-select" id="manufacturer" name="manufacturer" size="1" aria-label="Enter machine manufacturer (required)">
           <option>Select manufacturer</option>
     @foreach ($manufacturers as $manufacturer)
           <option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer }}</option>
     @endforeach
         </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Model:</span>
         <input class="form-control" type="text" id="model" name="model" size="20" aria-label="Enter model (required)"> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Serial Number:</span>
         <input class="form-control" type="text" id="serialNumber" name="serialNumber" size="20" aria-label="Enter serial number (required)"> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Software version:</span>
         <input class="form-control" type="text" id="softwareVersion" name="softwareVersion" size="50" aria-label="Enter software version">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Vendor site ID:</span>
         <input class="form-control" type="text" id="vendSiteID" name="vendSiteID" size="20" aria-label="Enter vendor site ID">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Manufacture date:</span>
         <input class="form-control" type="date" id="manufDate" name="manufDate" size="10" aria-label="Enter manufacture date">
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Install date:</span>
         <input class="form-control" type="date" id="installDate" name="installDate" size="10" aria-label="Enter installation date">
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Location:</span>
         <select class="form-select" id="location" name="location" size="1">
           <option>Select location</option>
     @foreach ($locations as $location)
           <option value="{{ $location->id }}">{{ $location->location }}</option>
     @endforeach
         </select> <span class="text-danger">*</span>
       </div>
       <div class="col input-group mb-3">
         <span class="input-group-text">Room:</span>
         <input class="form-control" type="text" id="room" name="room" size="20" aria-label="Enter room number"> <span class="text-danger">*</span>
       </div>
     </div>
     <div class="row">
       <div class="col input-group mb-3">
         <span class="input-group-text">Notes:</span>
         <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Enter any notes about the machine here" aria-label="Enter notes about the machine"></textarea>
       </div>
     </div>
     <button class="btn btn-primary" type="SUBMIT">Add machine</button>
</form>
<p><span class="text-danger">*</span> Required field</p>
@endsection
