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
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>Resolved</th><th>Recommendation</th><th>Date Added</th><th>Date Resolved</th><th>Work Order</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($recs as $rec)
                <tr>
                    @if ($rec->resolved)
     <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
     <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
     </svg></td>
                    <td>{{ $rec->recommendation }}</td>
                    @else
                    <td><input class="form--check-input" type="checkbox" id="recID" name="recID[]" value="{{ $rec->id }}" ></td>
                    <td><b>{{ $rec->recommendation }}</b></td>
                    @endif
                    <td>{{ $rec->rec_add_ts }}</td>
                    <td>{{ $rec->rec_resolve_date }}</td>
                    <td>{{ $rec->wo_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <hr>
@if (Auth::check())
    <div class="row">
      <div class="col input-group mb-3">
        <a href="{{ route('recommendations.createRecFor', $survey->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Add new recommendation">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
          </svg>Add new recommendation
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
