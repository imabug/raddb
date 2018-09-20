<!-- resources/views/recommendations/rec_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add new recommendations</h2>
<form class="form-inline" action="{{ route('recommendations.store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
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
        <p>Unresolved recommendations are in bold with the checkbox in front</p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Resolved</th><th>Recommendation</th><th>Date Added</th><th>Date Resolved</th><th>Work Order</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($recs as $rec)
                <tr>
                    @if ($rec->resolved)
                    <td><span class="glyphicon glyphicon-ok" aria-hidden-"true"></span></td>
                    <td>{{ $rec->recommendation }}</td>
                    @else
                    <td><input class="form-control" type="checkbox" id="recID" name="recID[]" value="{{ $rec->id }}" ></td>
                    <td><b>{{ $rec->recommendation }}</b></td>
                    @endif
                    <td>{{ $rec->rec_add_ts }}</td>
                    <td>{{ $rec->rec_resolve_date }}</td>
                    <td>{{ $rec->wo_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr>
        @if (Auth::check())
        <p><label for="surveyId">Survey ID: </label><input class="form-control" type="text" id="surveyId" name="surveyId" value="{{ $survey->id ?? '' }}" > <span class="text-danger">*</span></p>
        <p><label for="recommendation">Recommendation: </label><textarea class="form-control" id="recommendation" name="recommendation" rows="4" cols="80" placeholder="Enter recommendation"></textarea> <span class="text-danger">*</span></p>
        <p><label for="resolved">Resolved: </label> <input class="form-control" type="checkbox" id="resolved" name="resolved" value="1" ></p>
        <p><label for="WONum">Biomed Work Order Number:</label> <input class="form-control" type="text" id="WONum" name="WONum" size="20" maxlength="20" ></p>
        <p><label for="RecResolveDate">Resolution date:</label> <input class="form-control" id="RecResolveDate" name="RecResolveDate" type="date" size="20" maxlength="20" ></p>
        <p><label for="ServiceReport">Upload service report:</label> <input class="form-control" type="file" id="ServiceReport" name="ServiceReport" > (Max file size: {{ ini_get('post_max_size') }})</p>
        <p><label for="ResolvedBy">Resolved by:</label> <input class="form-control" id="ResolvedBy" name="ResolvedBy" type="text" size="20" maxlength="20" ></p>
        <p><button type="SUBMIT">Add recommendations</button></p>
        @endif
    </div>
</form>
<p><span class="text-danger">*</span> Required field</p>

@endsection
