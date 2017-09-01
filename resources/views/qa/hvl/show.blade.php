<!-- resources/views/qa/hvl/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Half value layer data for {{ $survey->machine->description }} ({{ $survey->test_date }} - Survey ID {{ $survey->id }})</h2>
{!! Charts::assets(['google']) !!}
@include('gendata.hvl')
@endsection
