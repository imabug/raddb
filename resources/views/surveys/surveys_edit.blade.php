<!-- resources/views/surveys/surveys_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a survey for {{ $machine->description }}</h2>
<form action="/surveys" method="POST">
{{ csrf_field() }}
{{ method_field('PUT') }}
<input type="hidden" name="id" value="{{ $survey->id }}" />
<input type="hidden" name="machineID" value="{{ $machines->id }}" />
<p><label>Machine:</label> {{ $machine->description }}
</p>
<p><label>Date tested (YYYY-MM-DD):</label> <input type="text" name="test_date" size="10" value="{{ $survey->test_date }}" /></p>
<p>
    <label>Tested by: </label>
    <select name="tester1ID" size="1">
    <option></option
    @foreach ($testers as $t)
    <option value="{{ $t->id }}"
    @if ($t->id == $tester1->id)
        selected="selected"
    @endif
    >{{ $t->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label>Tested by: </label>
    <select name="tester2ID" size="1">
    <option></option
    @foreach ($testers as $t)
    <option value="{{ $t->id }}"
    @if (isset($tester2) && ($t->id == $tester2->id))
        selected="selected"
    @endif
    >{{ $t->initials }}</option>
    @endforeach
    </select>
</p>
<p>
    <label>Type of test:</label>
    <select name="test_type" size="1">
    @foreach ($testtypes as $tt)
    <option value="{{ $tt->id }}"
    @if ($tt->id == $testtype->id)
        selected="selected"
    @endif
    >{{ $tt->test_type }}</option>
    @endforeach
    </select>
</p>
<p><label>Notes:</label> <textarea name="notes" rows="3" cols="70">{{ $survey->notes }}</textarea></p>
<p><label>Accession:</label> <input type="text" name="accession" size="12" value="{{ $survey->accession }}" /></p>

<p><button type="SUBMIT">Edit survey</button> / <a href="/">Main</a></p>
</form>

@endsection
