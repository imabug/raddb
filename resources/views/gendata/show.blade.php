<!-- resources/views/gendata/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Generator data for {{ $machine->description }} ({{ $survey->test_date }} - Survey ID {{ $survey->id }})</h2>
<ul class="nav nav-pills" role="tablist">
    <li role="presentation" class="active"><a href="#raw" aria-controls="raw" role="tab" data-toggle="pill">Raw data</a></li>
    <li role="presentation"><a href="#hvl" aria-controls="hvl" role="tab" data-toggle="pill">HVL</a></li>
    <li role="presentation"><a href="#radOutput" aria-controls="radOutput" role="tab" data-toggle="pill">Radiation Output</a></li>
</ul>
<div class="tab-content">
{!! Charts::assets(['google']) !!}
    <div role="tabpanel" class="tab-pane active" id="raw">
        @include('gendata.raw')
    </div>
    <div role="tabpanel" class="tab-pane" id="hvl">
        @include('gendata.hvl')
    </div>
    <div role="tabpanel" class="tab-pane" id="radOutput">
        @include('gendata.radOutput')
    </div>
</div>
@endsection
