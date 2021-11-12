<!-- resources/views/dashboard/survey_graph.blade.php -->
@extends('layouts.app')
@section('content')
  <h2>Survey Count Graphs</h2>
  {{--
  {!! Charts::assets(['google']) !!}
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

  --}}
  
  <!-- Chart's container -->
  <div id="chart" style="height: 300px;"></div>
  <!-- Charting library -->
  <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
  <!-- Chartisan -->
  <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
  <!-- Your application script -->
  <script>
   const chart = new Chartisan({
     el: '#chart',
     url: "@chart('survey_graph')",
   });
  </script>
  
@endsection
