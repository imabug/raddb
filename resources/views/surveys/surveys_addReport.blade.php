<!-- resources/views/surveys/surveys_addReport.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add survey report</h2>

<form class="form-inline" action="{{ route('surveyreports.store') }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
  <div class="row">
    <div class="col input-group mb-3">
      <span class="input-group-text">Survey ID: </span>
      <input class="form-control" type="number" id="surveyId" name="surveyId" list="surveys" aria-label="Enter machine ID">
    </div>
    <div class="col input-group mb-3">
      <span class="input-group-text">Upload survey report: </span>
      <input class="form-control" type="file" id="surveyReport" name="surveyReport" aria-label="Survey report to upload">
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit survey report</button>
</form>
@endsection
