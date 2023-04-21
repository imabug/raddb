{{-- resources/views/recommendations/rec_create.blade.php --}}
{{-- Used by the create() method in RecommendationController --}}}}

@extends('layouts.app')

@section('content')
  <h2>Add new recommendations</h2>
  @if (isset($recs))
    <h3>Survey recommendations for <a href="{{ route('machines.show', $survey->machine->id) }}">{{ $survey->machine->description }}</a> (Survey ID {{ $survey->id }})</h3>
    @if ($serviceReports->count() > 0)
      <h3>Service Reports</h3>
      <ol>
        @foreach ($serviceReports as $sr)
          <li><a href="{{ $sr->getURL() }}" target="_blank">{{ $sr->name }}</a>
        @endforeach
      </ol>
    @endif

    <form class="form-inline" action="{{ route('recommendations.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col input-group mb-3">
          <p>Unresolved recommendations are in bold with the checkbox in front</p>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Resolved</th><th>Recommendation</th><th>Date Added</th><th>Date Resolved</th><th>Work Order</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recs as $rec)
                <tr>
                  @if ($rec->resolved)
                    <td><x-glyphs.check /></td>
                    <td>{{ $rec->recommendation }}</td>
                  @else
                    <td><input class="form-check-input" type="checkbox" id="recID" name="recID[]" value="{{ $rec->id }}" ></td>
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
  @endif
  <hr>
  @if (Auth::check())
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Survey ID:</span>
        <input class="form-control" type="text" id="surveyId" name="surveyId" value="{{ $survey->id ?? '' }}" aria-label="Enter survey ID (required)"> <span class="text-danger">*</span>
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Resolved:</span>
        <input class="form-check-input" type="checkbox" id="resolved" name="resolved" value="1" aria-label="Check box to mark as resolved">
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Biomed Work Order Number:</span>
        <input class="form-control" type="text" id="WONum" name="WONum" size="20" maxlength="20" aria-label="Enter biomed work order number">
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Resolution date:</span>
        <input class="form-control" id="RecResolveDate" name="RecResolveDate" type="date" size="20" maxlength="20" aria-label="Enter resolution date">
      </div>
      <div class="col input-group mb-3">
        <span class="input-group-text">Resolved by:</span>
        <input class="form-control" id="ResolvedBy" name="ResolvedBy" type="text" size="20" maxlength="20" aria-label="Enter the name of the person resolving the issue">
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Recommendation:</span>
        <textarea class="form-control" id="recommendation" name="recommendation" rows="4" cols="80" placeholder="Enter recommendation" aria-label="Enter recommendation"></textarea> <span class="text-danger">*</span>
      </div>
    </div>
    <div class="row">
      <div class="col input-group mb-3">
        <span class="input-group-text">Upload service report:</span>
        <input class="form-control" type="file" id="ServiceReport" name="ServiceReport" aria-label="Select service report file to upload"> (Max file size: {{ ini_get('post_max_size') }})
      </div>
    </div>
    <button class="btn btn-primary" type="SUBMIT">Add recommendations</button>
  @endif
    </form>
    <p><span class="text-danger">*</span> Required field</p>

@endsection
