<!-- resources/views/dashboard/survey_graph.blade.php -->
@extends('layouts.app')
@section('content')
<h2>Monthly survey count</h2>
{!! Charts::assets() !!}
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $allYears->render() !!}</p>
    </div>
</div>
@foreach ($yearCharts as $ych)
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $ych->render() !!}</p>
    </div>
</div>
@endforeach
@endsection
