<!-- resources/views/surveys/surveys_addReport.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add survey report</h2>

<form class="form-inline" action="{{ route('surveyreports.store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        <p><label for="surveyId">Survey ID: </label> <input class="form-control" type="number" id="surveyId" name="surveyId" list="surveys"></p>
        <p><label for="surveyReport">Upload survey report: </label> <input class="form-control" type="file" id="surveyReport" name="surveyReport" ></p>
        <p><button type="submit">Submit survey report</button></p>
        <datalist class="form-control" id="surveys" style="display:none;">
        @foreach ($surveys as $s)
            <option value="{{ $s->id }}">
        @endforeach
        </datalist>
    </div>
</form>
@endsection
