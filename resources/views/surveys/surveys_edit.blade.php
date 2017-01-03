<!-- resources/views/surveys/surveys_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit a survey for {{ $machine->description }}</h2>
<form class="form-inline" action="/surveys" method="POST">
{{ csrf_field() }}
{{ method_field('PUT') }}
<input class="form-control" type="hidden" id="id" name="id" value="{{ $survey->id }}" >
<input class="form-control" type="hidden" id="machineID" name="machineID" value="{{ $machines->id }}" >
<p>Machine: {{ $machine->description }}
</p>
<p><label for="test_date">Date tested:</label> <input class="form-control" type="date" id="test_date" name="test_date" size="10" value="{{ $survey->test_date }}" placeholder="YYYY-MM-DD" ></p>
<p>
    <label for="tester1ID">Tested by: </label>
    <select class="form-control" id="tester1ID" name="tester1ID" size="1">
    <option value="10" selected="="selected""></option>
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
    <label for="tester2ID">Tested by: </label>
    <select class="form-control" id="tester2ID" name="tester2ID" size="1">
    <option value="10" selected="="selected""></option>
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
    <label for="test_type">Type of test:</label>
    <select class="form-control" id="test_type" name="test_type" size="1">
    @foreach ($testtypes as $tt)
    <option value="{{ $tt->id }}"
    @if ($tt->id == $testtype->id)
        selected="selected"
    @endif
    >{{ $tt->test_type }}</option>
    @endforeach
    </select>
</p>
<p><label for="notes">Notes:</label> <textarea class="form-control" id="notes" name="notes" rows="3" cols="70">{{ $survey->notes }}</textarea></p>
<p><label for="accession">Accession:</label> <input class="form-control" type="text" id="accession" name="accession" size="12" value="{{ $survey->accession }}" ></p>

<p><button type="SUBMIT">Edit survey</button> / <a href="/">Main</a></p>
</form>

@endsection
