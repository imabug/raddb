{{-- resources/views/dashboard/survey_calendar.blade.php --}}
{{-- Used by DashboardSurveyCalendarController --}}
@extends('layouts.app')
@section('content')
  <h2>Daily Survey Count Calendar</h2>
  @foreach ($years as $y)
    <div id={{ 'perf_div'.$y->years }}></div>
    @calendarchart('Daily survey count - '.$y->years, 'perf_div'.$y->years)
  @endforeach
@endsection
