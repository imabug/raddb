<!-- resources/views/recommendations/recommendations.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Survey recommendations for {{ $machineDesc->description }} (Survey ID {{ $surveyID }})</h2>
<p>Unresolved recommendations are in bold with the checkbox in front</p>
<p>
<form class="form-inline" action="{{ route('recommendations.update', $surveyID) }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <table class="table">
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
                    @if (isset($rec->service_report_path))
                    <td><a href="{{ route('reports.show', ["service", $rec->id]) }}" target="_blank">{{ $rec->wo_number }}</a></td>
                    @else
                    <td>{{ $rec->wo_number }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        @if (Auth::check())
        <p>
            <a href="{{ route('recommendations.createRecFor', $surveyID) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this tube">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Add new recommendation
            </a>
        </p>
        <p><label for="WONum">Biomed Work Order Number:</label> <input class="form-control" type="text" id="WONum" name="WONum" size="20" maxlength="20" ></p>
        <p><label for="RecResolveDate">Resolution date:</label> <input class="form-control" id="RecResolveDate" name="RecResolveDate" type="date"></p>
        <p><label for="ServiceReport">Upload service report:</label> <input class="form-control" type="file" id="ServiceReport" name="ServiceReport" > (Max file size: {{ ini_get('post_max_size') }})</p>
        <p><label for="ResolvedBy">Resolved by:</label> <input class="form-control" id="ResolvedBy" name="ResolvedBy" type="text" size="20" maxlength="20" ></p>
        <p><button type="SUBMIT">Resolve recommendations</button></p>
        @endif
    </div>
</form>
</p>

@endsection
