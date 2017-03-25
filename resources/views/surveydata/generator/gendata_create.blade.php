<!-- resources/views/surveydata/gendata_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add generator test data for {{ $machine->description }} (Survey {{ $survey->id }})</h2>
<p>This form is used to add generator test data from the survey. Paste data from cells AA688:BB747 of the spreadsheet</p>
<form class="form-horizontal" action="{{route('gendata.store')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="surveyId" value="{{ $survey->id }}">
    <div class="form-group">
    <label for="tubeId" class="control-label">Select a tube:</label> <select class="form-control" name="tubeId" id="tubeId">
    @foreach ($tubes as $tube)
        <option value="{{ $tube->id }}">{{ $tube->housing_model }} / SN {{ $tube->housing_sn }}</option>
    @endforeach
    </select>
    </div>
    <div class="form-group">
    <label for="generatorData" class="control-label">Generator test data</label><br>
        <textarea class="form-control" name="generatorData" rows="10" placeholder="Paste selection from spreadsheet"></textarea>
    </div>
    <button type="submit">Submit data</button>
</form>
@endsection
