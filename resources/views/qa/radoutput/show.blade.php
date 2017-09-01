<!-- resources/views/qa/radoutput/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Radiation output data for {{ $survey->machine->description }} ({{ $survey->test_date }} - Survey ID {{ $survey->id }})</h2>
{!! Charts::assets(['google']) !!}
@include('gendata.radOutput')
@endsection
