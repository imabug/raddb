<!-- resources/views/dashboard/test_status.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Testing Status Dashboard</h2>
<p>Table legend</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td class="bg-success">Current</td>
            <td class="bg-info">Due within 30 days</td>
            <td class="bg-warning">Overdue &lt; 13 months</td>
            <td class="bg-danger">Overdue &gt; 13 months</td>
            <td class="bg-primary">Scheduled, not tested yet</td>
        </tr>
    </tbody>
</table>

@foreach ($machines as $key=>$modality)
<h3>Modality: {{ $key }} ({{ count($modality) }})</h3>
<table class="table table-bordered">
@foreach ($modality->chunk(5) as $mod_chunk)
<tr>
@foreach ($mod_chunk as $m)
<td class="text-center">
    <a href="{{ route('machines.show', $m->id) }}">{{ $m->description}}</a><br />
    <a href="{{ route('machines.showLocation', $m->location_id) }}">{{ $m->location->location }}</a><br />
@foreach ($m->testdate as $td)
    @if ($loop->first)
@php
$today = new DateTime("now");
$test_date = new DateTime($td->test_date);
$days = $test_date->diff($today)->format('%a');

if ($days < 355) {
    if ($td->test_date > date("Y-m-d")) {
        echo "<div class=\"bg-primary\">" . $td->test_date . "</div>";
    }
    else {
        echo "<div class=\"bg-success\">" . $td->test_date . "</div>";
    }
}
else if (($days >= 335) && ($days < 365)) {
    echo "<div class=\"bg-info\">" . $td->test_date . "</div>";
}
else if (($days >= 365) && ($days < 395)) {
    echo "<div class=\"bg-warning\">" . $td->test_date . "</div>";
}
else if ($days > 395) {
    echo "<div class=\"bg-danger\">" . $td->test_date . "</div>";
}
@endphp
    @endif
@endforeach
</td>
@endforeach
</tr>
@endforeach
</table>
@endforeach
<p>Table legend</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td class="bg-success">Current</td>
            <td class="bg-info">Due within 30 days</td>
            <td class="bg-warning">Overdue &lt; 13 months</td>
            <td class="bg-danger">Overdue &gt; 13 months</td>
            <td class="bg-primary">Scheduled, not tested yet</td>
        </tr>
    </tbody>
</table>

@endsection
