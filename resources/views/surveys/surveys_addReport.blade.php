{{-- resources/views/surveys/surveys_addReport.blade.php --}}
{{-- Used by the create() method in SurveyReportController --}}
@extends('layouts.app')

@section('content')
<h2>Add survey report</h2>

<form class="form-inline" action="{{ route('surveyreports.store') }}" method="post" enctype="multipart/form-data">
@csrf
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Survey ID: </span>
      <input class="form-control" type="number" id="surveyId" name="surveyId" list="surveys" aria-label="Enter machine ID">
    </div>
  </div>
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Survey report: </span>
      <input class="form-control" type="file" id="surveyReport" name="surveyReport" aria-label="Survey report to upload">
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit survey report</button>
</form>
@endsection
