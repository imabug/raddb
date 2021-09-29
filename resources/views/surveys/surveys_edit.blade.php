<!-- resources/views/surveys/surveys_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a survey for {{ $machine->description }}</h2>
<form class="form-inline" action="{{ route('surveys.update', $survey->id) }}" method="POST">
@csrf
@method('PUT')
  <input class="form-control" type="hidden" id="id" name="id" value="{{ $survey->id }}" >
  <input class="form-control" type="hidden" id="machineID" name="machineID" value="{{ $machine->id }}" >
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Machine:</span>
      <input class="form-control" type="text" value="{{ $machine->description }}" aria-label="Machine description" readonly />
    </div>
    <div class="col input-group mb-3">
      <span class="input-group-text">Date tested:</span>
      <input class="form-control" type="date" id="test_date" name="test_date" size="10" value="{{ $survey->test_date }}" >
    </div>
    <div class="col input-group mb-3">
      <span class="input-group-text">Accession:</span>
      <input class="form-control" type="text" id="accession" name="accession" size="12" value="{{ $survey->accession }}" aria=label="Accession number">
    </div>
    <div class="col input-group mb-3">
      <span class="input-group-text">Type of test:</span>
      <select class="form-select" id="test_type" name="test_type" size="1">
     @foreach ($testtypes as $tt)
        <option value="{{ $tt->id }}"
     @if ($tt->id == $testtype->id)
          selected="selected"
     @endif
         >{{ $tt->test_type }}</option>
     @endforeach
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Tested by: </span>
      <select class="form-select" id="tester1ID" name="tester1ID" size="1" aria-label="Select tester 1 (required)">
        <option value="10" selected="="selected""></option>
    @foreach ($testers as $t)
        <option value="{{ $t->id }}"
    @if ($t->id == $tester1->id)
          selected="selected"
    @endif
        >{{ $t->initials }}</option>
    @endforeach
      </select>
    </div>
    <div class="col input-group mb-3">
      <span class="input-group-text">Tested by: </span>
      <select class="form-select" id="tester2ID" name="tester2ID" size="1" aria-label="select tester 2">
        <option value="10" selected="="selected""></option>
     @foreach ($testers as $t)
        <option value="{{ $t->id }}"
     @if (isset($tester2) && ($t->id == $tester2->id))
          selected="selected"
     @endif
        >{{ $t->initials }}</option>
         @endforeach
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Notes:</span>
      <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" aria-label="Survey notes">{{ $survey->notes }}</textarea>
    </div>
  </div>

  <button class="btn btn-primary" type="SUBMIT">Edit survey</button>
</form>

@endsection
