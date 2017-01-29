<!-- resources/views/dashboard/survey_graph.blade.php -->
@extends('layouts.app')
@section('content')
<h2>Survey Count Graphs</h2>
{!! Charts::assets() !!}
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $allYears->render() !!}</p>
    </div>
</div>
@foreach ($yearCharts as $yearChart)
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $yearChart->render() !!}</p>
    </div>
</div>
@endforeach
@endsection
