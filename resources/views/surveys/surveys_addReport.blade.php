<!-- resources/views/surveys/surveys_addReport.blade.php -->

@extends('layouts.app')

@section('content')
@if (isset($machineDesc->description))
<h2>Add survey report for {{ $machineDesc->description }}</h2>
@else
<h2>Add survey report</h2>
@endif

<form class="form-inline" action="/surveys/addReport" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
@if (!is_null($surveyId))
        <input type="hidden" id="surveyId" name="surveyId" value="{{ $surveyId }}">
@endif
        <p><label for="surveyId">Survey ID: </label> <input class="form-control" type="text" id="surveyId" name="surveyId" value="{{ $surveyId or '' }}"></p>
        <p><label for="surveyReport">Upload survey report: </label> <input class="form-control" type="file" id="surveyReport" name="surveyReport" /></p>
        <p><button type="submit">Submit survey report</button> / <a href="/">Main</a></p>
    </div>
</form>
@endsection
