<!-- resources/views/mammo/mamCE.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Mammography Continued Experience Listing for {{ $tester->name }}</h2>
<p>This report lists the two most recent surveys performed on mammography units.</p>
<p>Report generated {{ $reportDate }}</p>
<h3>Mammography Units</h3>
@foreach ($mammoMachines as $mamm)
    <h4>{{ $mamm->description }}</h4>
    @foreach ($mamm->testdate->take(-2) as $testdate)
        <p>{{ $testdate->test_date }}</p>
    @endforeach
@endforeach

<h3>Mammography Workstations</h3>
@foreach ($mammoWorkstations as $wrk)
    <h4>{{ $wrk->description }}</h4>
    @foreach ($wrk->testdate->take(-2) as $wrkDate)
        <p>{{ $wrkDate->test_date }}</p>
    @endforeach
@endforeach
@endsection
