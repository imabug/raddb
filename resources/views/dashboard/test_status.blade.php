<!-- resources/views/dashboard/test_status.blade.php -->

@extends('layouts.app')

@section('css')
<style type="text/css">
.red {background-color: #FF3333;}
.orange {background-color: #FF8000;}
.yellow {background-color: #FFFF33;}
.green {background-color: #33FF33;}
.blue {background-color: #80FFFF;}
td {text-align: center;}
</style>

@endsection

@section('content')
<h2>Equipment Testing Status Dashboard</h2>
<h3>Table legent</a>
<table>
  <tr>
    <td class="green">Current</td>
    <td class="yellow">Due within 30 days</td>
    <td class="orange">Overdue &lt; 13 months</td>
    <td class="red">Overdue &gt; 13 months</td>
    <td class="blue">Scheduled, not tested yet</td>
</tr>
</table>

@endsection