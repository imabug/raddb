<!-- resources/views/surveys/rec_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add new recommendations</h2>
<form class="form-inline" action="/recommendations" method="post" enctype="multipart/form-data">
    <div class="form-group">
        {{ csrf_field() }}
        @if (isset($recs))
        <h3>Survey recommendations for {{ $machineDesc->description }} (Survey ID {{ $surveyId }})</h3>
        <p>Unresolved recommendations are in bold with the checkbox in front</p>
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
                    <td><input class="form-control" type="checkbox" id="recID" name="recID[]" value="{{ $rec->id }}" /></td>
                    <td><b>{{ $rec->recommendation }}</b></td>
                    @endif
                    <td>{{ $rec->rec_add_ts }}</td>
                    <td>{{ $rec->rec_resolve_date }}</td>
                    @if (isset($rec->service_report_path))
                    <td><a href="/{{ $rec->service_report_path }}">{{ $rec->wo_number }}</a></td>
                    @else
                    <td>{{ $rec->wo_number }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <p><label for="surveyId">Survey ID: </label><input class="form-control" type="text" id="surveyId" name="surveyId" value="{{ $surveyId or '' }}" /></p>
        <p><label for="recommendation">Recommendation: </label><textarea class="form-control" id="recommendation" name="recommendation" rows="4" cols="80" placeholder="Enter recommendation"></textarea></p>
        <p><label for="resolved">Resolved: </label><input class="form-control" type="checkbox" id="resolved" name="resolved" value="1" /></p>
        <p><label for="WONum">Biomed Work Order Number:</label> <input class="form-control" type="text" id="WONum" name="WONum" size="20" maxlength="20" /></p>
        <p><label for="RecResolveDate">Resolution date:</label> <input class="form-control" id="RecResolveDate" name="RecResolveDate" type="text" size="20" maxlength="20" placeholder="YYYY-MM-DD" /></p>
        <p><label for="ServiceReport">Upload service report:</label> <input class="form-control" type="file" id="ServiceReport" name="ServiceReport" /></p>
        <p><label for="ResolvedBy">Resolved by:</label> <input class="form-control" id="ResolvedBy" name="ResolvedBy" type="text" size="20" maxlength="20" /></p>
        <p><button type="SUBMIT">Resolve recommendations</button> / <a href="/">Main</a></p>
    </div>
</form>


@endsection
