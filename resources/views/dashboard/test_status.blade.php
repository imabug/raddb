<!-- resources/views/dashboard/test_status.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Testing Status Dashboard</h2>
<h3>Table legend</h3>
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
<h4>Modality: {{ $key }} ({{ count($modality) }})</h4>
<table>
@foreach ($modality->chunk(5) as $mod_chunk)
<tr>
@foreach ($mod_chunk as $m)
<td class="text-center">
    {{ $m->description}}<br />
    {{ $m->location->location }}<br />
@foreach ($m->testdate as $td)
    @if ($loop->first)
        {{ $td->test_date }}
    @endif
@endforeach
</td>
@endforeach
</tr>
@endforeach
</table>
@endforeach
@endsection
