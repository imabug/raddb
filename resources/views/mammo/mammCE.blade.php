<!-- resources/views/mammo/mamCE.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Mammography Continued Experience Listing for {{ $tester->name }}</h2>
<p>This report lists the two most recent surveys performed on mammography units.</p>
<p>Report generated {{ $reportDate }}</p>
<h3>Mammography Units</h3>
@foreach ($mammoMachines as $mamm)
<table class="table">
    <thead>
        <tr>
            <th colspan="2">{{ $mamm->description }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        @foreach ($mamm->testdate->take(-2) as $testdate)
            <td>{{ $testdate->test_date }}</td>
        @endforeach
        </tr>
    </tbody>
</table>
@endforeach

<h3>Mammography Workstations</h3>
@foreach ($mammoWorkstations as $wrk)
<table class="table">
    <thead>
        <tr>
            <th colspan="2">{{ $wrk->description }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        @foreach ($wrk->testdate->take(-2) as $wrkDate)
            <td>{{ $wrkDate->test_date }}</td>
        @endforeach
        </tr>
    </tbody>
</table>
@endforeach
@endsection
