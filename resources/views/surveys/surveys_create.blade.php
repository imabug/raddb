<!-- resources/views/surveys/surveys_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add new survey
@if (isset($id))
    for {{ $machines->description }}
@endif
</h2>
<form action="/surveys" method="POST">
{{ csrf_field() }}
<p><label>Machine:</label>
@if (isset($id))
{{ $machines->description }}
<input type="hidden" name="machineID" value="{{ $machines->id }}" />
@else
    <select name="machineID" size="1">
    <option>Select a machine</option>
    @foreach ($machines as $machine)
    <option value="{{ $machine->id }}">{{ $machine->description }}</option>
    @endforeach
    </select>
@endif
</p>
<p><label>Date tested (YYYY-MM-DD):</label> <input type="text" name="test_date" size="10" /> <input type="checkbox" name="today" />Today</p>
<p>
    <label>Tested by: </label>
    <select name="tester1ID" size="1">
    <option value="0"></option
    @foreach ($testers as $tester)
    <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label>Tested by: </label>
    <select name="tester2ID" size="1">
    <option value="0"></option
    @foreach ($testers as $tester)
    <option value="{{ $tester->id }}">{{ $tester->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label>Type of test:</label>
    <select name="test_type" size="1">
    @foreach ($testtypes as $testtype)
    <option value="{{ $testtype->id }}">{{ $testtype->test_type }}</option>
    @endforeach
    </select>
</p>
<p><label>Notes:</label> <textarea name="notes" rows="3" cols="70">Enter any notes about the survey</textarea></p>
<p><label>Accession:</label> <input type="text" name="accession" size="12" /></p>

<p><button type="SUBMIT">Add survey</button> / <a href="/">Main</a></p>
</form>

@endsection
