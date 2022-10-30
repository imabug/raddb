<!-- resources/views/dashboard/survey_calendar.blade.php -->
@extends('layouts.app')
@section('content')
  <h2>Survey Count by Test Category</h2>
  @foreach ($years as $y)
    <div id={{ 'perf_div'.$y->years }}></div>
    @piechart('Yearly survey counts by test type - '.$y->years, 'perf_div'.$y->years)
  @endforeach
@endsection
