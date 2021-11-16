<!-- resources/views/dashboard/survey_counts.blade.php -->
@extends('layouts.app')
@section('content')
  <h2>Survey Count Graphs</h2>
  <div id="perf_div"></div>
  @columnchart('Yearly Survey Count', 'perf_div')

  @foreach ($years as $y)
    <div id={{ 'perf_div'.$y->years }}></div>
    @columnchart('Survey count - '.$y->years, 'perf_div'.$y->years)
  @endforeach
@endsection
