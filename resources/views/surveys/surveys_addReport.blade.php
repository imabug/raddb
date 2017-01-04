<!-- resources/views/surveys/surveys_addReport.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add survey report</h2>

<form class="form-inline" action="/surveys/storeReport" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <p><label for="surveyId">Survey ID: </label> <input class="form-control" type="text" id="surveyId" name="surveyId"></p>
        <p><label for="surveyReport">Upload survey report: </label> <input class="form-control" type="file" id="surveyReport" name="surveyReport" ></p>
        <p><button type="submit">Submit survey report</button> / <a href="/">Main</a></p>
    </div>
</form>
@endsection
