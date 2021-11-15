<!-- resources/views/dashboard/survey_graph.blade.php -->
@extends('layouts.app')
@section('content')
  <h2>Survey Count Graphs</h2> 
  <!-- Chart's container -->
  <div id="chart" style="height: 600px;"></div>
  <!-- Charting library -->
  <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
  <!-- Chartisan -->
  <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
  <!-- Your application script -->
  <script>
   const chart = new Chartisan({
     el: '#chart',
     url: "@chart('survey_graph')",
     hooks: new ChartisanHooks()
       .colors(),
   });
  </script>
@endsection
