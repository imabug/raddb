<!-- resources/views/recommendations/recommendations.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Survey recommendations for <a href="{{ route('machines.show', $survey->machine->id) }}">{{ $survey->machine->description }}</a> (Survey ID {{ $survey->id }})</h2>
@if ($serviceReports->count() > 0)
<h3>Service Reports</h3>
<ol>
@foreach ($serviceReports as $sr)
    <li><a href="{{ $sr->getURL() }}" target="_blank">{{ $sr->name }}</a>
@endforeach
</ol>
@endif
<p>Unresolved recommendations are in bold with the checkbox in front</p>
<p>
<form class="form-inline" action="{{ route('recommendations.update', $survey->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col input-group mb-3">
        <livewire:recommendations-for-survey-table :surveyId="$survey->id" />
      </div>
    </div>
    <hr>
@if (Auth::check())
    <div class="row">
      <div class="col input-group mb-3">
        <a href="{{ route('recommendations.createRecFor', $survey->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Add new recommendation">
          <x-glyphs.plus />Add new recommendation
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Biomed Work Order Number:</span>
        <input class="form-control" type="text" id="WONum" name="WONum" size="20" maxlength="20" aria-label="Enter biomed work order number">
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Resolution date:</span>
        <input class="form-control" id="RecResolveDate" name="RecResolveDate" type="date" aria-label="Enter resolution date (required)"> <span class="text-danger">*</span>
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Resolved by:</span>
        <input class="form-control" id="ResolvedBy" name="ResolvedBy" type="text" size="20" maxlength="20" aria-label="Enter name of person resolving the issue"> <span class="text-danger">*</span>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Upload service report:</span>
        <input class="form-control" type="file" id="ServiceReport" name="ServiceReport" aria-label="Select service report file to upload"> (Max file size: {{ ini_get('post_max_size') }})
      </div>
    </div>
@endif
     <button class="btn btn-primary" type="SUBMIT">Resolve recommendations</button>
</form>
</p>
<p><span class="text-danger">*</span> Required field when resolving recommendations</p>
@endsection
