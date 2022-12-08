{{-- resources/views/tubes/tubes_edit.blade.php --}}
{{-- Used by the edit() method in TubeController --}}
@extends('layouts.app')

@section('content')
<h2>Edit a tube</h2>
<p>
<form class="form-inline" action="{{route('tubes.update', $tube->id)}}" method="POST">
     @csrf
     @method('PUT')
<input type="hidden" id="machine_id" name="machine_id" value="{{ $machine->id }}" >
<input type="hidden" id="tube_id" name="tube_id" value="{{$tube->id}}">
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Machine:</span>
      <input type="text" value="{{ $machine->description }}" aria-label="Machine description" readonly />
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Status:</span>
     <select class="form-select" id="tube_status" name="tube_status" size="1" aria-label="Select x-ray tube status">
       <option>Select status</option>
       <option value="Active"
     @if ($tube->tube_status == "Active")
         selected="selected"
     @endif
         >Active</option>
       <option value="Removed"
     @if ($tube->tube_status == "Removed")
         selected="selected"
     @endif
         >Removed</option>
     </select>
    </div>
 </div>
 <div class="row">
    <div class="col input-group mb-3">
     <span class="input-group-text">Housing Manufacturer:</span>
     <select class="form-select" id="hsgManufID" name="hsgManufID" size="1" aria-label="Select x-ray tube housing manufacturer">
       <option>Select manufacturer</option>
     @foreach ($manufacturers as $manufacturer)
       <option value="{{ $manufacturer->id }}"
     @if ($manufacturer->id == $tube->housing_manuf_id)
         selected="selected"
     @endif
       >{{ $manufacturer->manufacturer }}</option>
     @endforeach
     </select>
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Housing Model:</span>
     <input class="form-control" type="TEXT" id="hsgModel" name="hsgModel" size="20" value="{{ $tube->housing_model }}" aria-label="Enter x-ray tube housing model">
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Housing SN:</span>
     <input class="form-control" type="TEXT" id="hsgSN" name="hsgSN" size="20" value="{{ $tube->housing_sn }}" aria-label="Enter x-ray tube housing serial number">
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
     <span class="input-group-text">Insert Manufacturer:</span>
     <select class="form-select" id="insertManufID" name="insertManufID" size="1" aria-label="Select x-ray tube insert manufacturer">
       <option>Select manufacturer</option>
     @foreach ($manufacturers as $manufacturer)
       <option value="{{ $manufacturer->id }}"
     @if ($manufacturer->id == $tube->insert_manuf_id)
         selected="selected"
     @endif
       >{{ $manufacturer->manufacturer }}</option>
     @endforeach
     </select>
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Insert Model:</span>
     <input class="form-control" type="text" id="insertModel" name="insertModel" size="20" value="{{ $tube->insert_model }}" aria-label="Enter x-ray tube inesrt model">
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Insert SN:</span>
     <input class="form-control" type="text" id="insertSN" name="insertSN" size="20" value="{{ $tube->insert_sn }}" aria-label="Enter x-ray tube insert serial number">
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
     <span class="input-group-text">Manufacture Date:</span>
     <input class="form-control" type="date" id="manufDate" name="manufDate" size="10" value="{{ $tube->manuf_date }}" aria-label="Enter x-ray tube manufacture date">
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Install date:</span>
     <input class="form-control" type="date" id="installDate" name="installDate" size="10" value="{{ $tube->install_date }}" aria-label="Enter x-ray tube install date">
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
     <span class="input-group-text">Large FS (mm):</span>
     <input class="form-control" type="text" id="lfs" name="lfs" size="4" value="{{ $tube->lfs }}" aria-label="Enter large focal spot size (mm)">
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Medium FS (mm):</span>
     <input class="form-control" type="text" id="mfs" name="mfs" size="4" value="{{ $tube->mfs }}" aria-label="Enter medium focal spot size (mm)">
    </div>
    <div class="col input-group mb-3">
     <span class="input-group-text">Small FS (mm):</span>
     <input class="form-control" type="text" id="sfs" name="sfs" size="4" value="{{ $tube->sfs }}" aria-label="Enter small focal spot size (mm)">
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
     <span class="input-group-text">Notes</span>
     <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" aria-label="Enter notes">{{$tube->notes}} </textarea>
    </div>
  </div>
  <button class="btn btn-primary" type="SUBMIT">Modify tube</button>
</form>
</p>
@endsection
