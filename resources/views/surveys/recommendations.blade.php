<!-- resources/views/surveys/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Survey recommendations for {{ $machineDesc }}</h2>
<table>
    <tr>
        <th>Resolved</th><th>Recommendation</th><th>Date Added</th><th>Date Resolved</th><th>Work Order</th>
    </tr>
    @foreach ($recs as $rec)
    <tr>
        <td></td>
        <td>{{ $rec->recommendation }}</td>
        <td>{{ $rec->rec_add_ts }}</td>
        <td>{{ $rec->rec_resolve_date }}</td>
        <td><a href="/{{ $rec->service_report_path }}">{{ $rec->wo_number }}</a></td>
    </tr>
    @endforeach
</table>

@endsection
