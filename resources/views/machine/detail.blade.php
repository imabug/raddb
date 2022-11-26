<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
  @if ($machine->machine_status == "Inactive" || $machine->machine_status == "Removed")
    <h2><span class="label label-danger">{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</span></h2>
  @else
    <h2><span class="label label-primary">{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</span></h2>
  @endif

  <ul class="nav nav-pills mb-5" role="tablist">
    <li role="presentation" class="nav-item">
      <button class="nav-link active" id="machine-info" data-bs-toggle="pill" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Machine Info</button></li>
    <li role="presentation" class="nav-item">
      <button class="nav-link" id="machine-tubes" data-bs-toggle="pill" data-bs-target="#tubes" type="button" role="tab" aria-controls="tubes" aria-selected="false">Tubes</button></li>
    <li role="presentation" class="nav-item">
      <button class="nav-link" id="machine-opnotes" data-bs-toggle="pill" data-bs-target="#opnotes" type="button" role="tab" aria-controls="opnotes" aria-selected="false">Operational Notes</button></li>
    <li role="presentation">
      <button class="nav-link" id="machine-surveys" data-bs-toggle="pill" data-bs-target="#surveys" type="button "aria-controls="surveys" role="tab" aria-selected="false">Surveys</button></li>
    <li role="presentation">
      <button class="nav-link" id="machine-recs" data-bs-toggle="pill" data-bs-target="#recs" type="button" aria-controls="recs" role="tab" aria-selected="false">Recommendations</button></li>
  </ul>
  <div class="tab-content" id="machineTabs">
    <div role="tabpanel" class="tab-pane show active" id="info" aria-labelledby="machine-info">
      @include('machine.info')
    </div>
    <div role="tabpanel" class="tab-pane" id="tubes" aria-labelledby="machine-tubes">
      @include('machine.tubes')
    </div>
    <div role="tabpanel" class="tab-pane" id="opnotes"  aria-labelledby="machine-opnotes">
      @include('machine.opnotes')
    </div>
    <div role="tabpanel" class="tab-pane" id="surveys" aria-labelledby="machine-surveys">
      @include('machine.surveys')
    </div>
    <div role="tabpanel" class="tab-pane" id="recs" aria-labelledby="machine-recs">
      @include('machine.recs')
    </div>
  </div>
@endsection
