<!-- resources/views/surveys/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Survey recommendations for {{ $machineDesc->description }} (Survey ID {{ $surveyID }})</h2>
<p>Unresolved recommendations are in bold with the checkbox in front</p>

<table>
    <tr>
        <th>Resolved</th><th>Recommendation</th><th>Date Added</th><th>Date Resolved</th><th>Work Order</th>
    </tr>
    @foreach ($recs as $rec)
    <tr>
        @if ($rec->resolved)
        <td></td>
        <td>{{ $rec->recommendation }}</td>
        @else
        <td><input type="checkbox" name="Resolved[]" value="{{ $rec->id }}" /></td>
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
</table>

@endsection
