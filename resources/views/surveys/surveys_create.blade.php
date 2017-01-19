<!-- resources/views/surveys/surveys_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add new survey
@if (isset($id))
    for {{ $machines->description }}
@endif
</h2>
<form class="form-inline" action="{{ route('surveys.store') }}" method="POST">
{{ csrf_field() }}
<p><label for="machineID">Machine:</label>
@if (isset($id))
{{ $machines->description }}
<input class="form-control" type="hidden" id="machineID" name="machineID" value="{{ $machines->id }}" autofocus>
@else
    <select class="form-control" name="machineID" size="1" autofocus>
    <option>Select a machine</option>
    @foreach ($machines as $machine)
    <option value="{{ $machine->id }}">{{ $machine->description }}</option>
    @endforeach
    </select>
@endif
</p>
<p><label for="test_date">Date tested:</label> <input class="form-control" type="date" id="test_date" name="test_date" size="10" required></p>
<p>
    <label for="tester1ID">Tested by: </label>
    <select class="form-control" id="tester1ID" name="tester1ID" size="1">
    <option value="10" selected="="selected""></option>
    @foreach ($testers as $tester)
    <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label for="tester2ID">Tested by: </label>
    <select class="form-control" id="tester2ID" name="tester2ID" size="1">
    <option value="10" selected="="selected""></option>
    @foreach ($testers as $tester)
    <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label for="test_type">Type of test:</label>
    <select class="form-control" id="test_type" name="test_type" size="1">
    @foreach ($testtypes as $testtype)
    <option value="{{ $testtype->id }}">{{ $testtype->test_type }}</option>
    @endforeach
    </select>
</p>
<p><label for="notes">Notes:</label> <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Enter any notes about the survey"></textarea></p>
<p><label for="accession">Accession:</label> <input class="form-control" type="text" id="accession" name="accession" size="12" /></p>

<p><button type="SUBMIT">Add survey</button></p>
</form>

@endsection
