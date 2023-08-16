{{-- resources/views/surveys/surveys_create.blade.php --}}
{{-- Used by the create() method in TestDateController --}}
@extends('layouts.app')

@section('content')
  <h2>Add new survey
    @if (isset($id))
      for {{ $machines->description }}
    @endif
  </h2>
  <form class="form-inline" action="{{ route('surveys.store') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Machine:</span>
        @if (isset($id))
          {{ $machines->description }}
          <input class="form-control" type="hidden" id="machineID" name="machineID" value="{{ $machines->id }}" autofocus aria-label="Select machine">
        @else
          <select class="form-select" name="machineID" size="1" autofocus aria-label="Select machine">
            <option>Select a machine</option>
            @foreach ($machines as $machine)
              <option value="{{ $machine->id }}">{{ $machine->description }}</option>
            @endforeach
          </select> <span class="text-danger">*</span>
        @endif
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Date tested:</span>
        <input class="form-control" type="date" id="test_date" name="test_date" size="10" required aria-label="Enter test date (required)"> <span class="text-danger">*</span>
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Type of test:</span>
        <select class="form-select" id="test_type" name="test_type" size="1" aria-label="Select test type (required)">
          @foreach ($testtypes as $testtype)
            <option value="{{ $testtype->id }}">{{ $testtype->test_type }}</option>
          @endforeach
        </select> <span class="text-danger">*</span>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Tested by: </span>
        <select class="form-select" id="tester1ID" name="tester1ID" size="1" aria-label="Select tester 1 (required)">
          <option value="" selected="="selected""></option>
          @foreach ($testers as $tester)
            <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
          @endforeach
        </select> <span class="text-danger">*</span>
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Tested by: </span>
        <select class="form-select" id="tester2ID" name="tester2ID" size="1" aria-label="Select tester 2">
          <option value="" selected="="selected""></option>
          @foreach ($testers as $tester)
            <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Accession:</span>
        <input class="form-control" type="text" id="accession" name="accession" size="12" aria-label="Accession number"/>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Notes:</span>
        <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Enter any notes about the survey" aria-label="Enter notes about the survey"></textarea>
      </div>
    </div>
    <button class="btn btn-primary" type="SUBMIT">Add survey</button>
  </form>
  <p><span class="text-danger">*</span> Required field</p>
@endsection
