<!-- resources/views/dashboard/yearly_survey_count.blade.php -->
@extends('layouts.app')
@section('content')
  <h2>Survey Count Graphs</h2>
  <div id="perf_div"></div>
  @columnchart('Yearly Survey Count', 'perf_div')
@endsection
