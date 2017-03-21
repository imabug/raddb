<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Machine Information</h2>
<ul class="nav nav-pills" role="tablist">
    <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="pill">Machine Info</a></li>
    <li role="presentation"><a href="#tubes" aria-controls="tubes" role="tab" data-toggle="pill">Tubes</a></li>
    <li role="presentation"><a href="#opnotes" aria-controls="opnotes" role="tab" data-toggle="pill">Operational Notes</a></li>
    <li role="presentation"><a href="#surveys" aria-controls="surveys" role="tab" data-toggle="pill">Surveys</a></li>
    <li role="presentation"><a href="#recs" aria-controls="recs" role="tab" data-toggle="pill">Recommendations</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="info">
        @include('machine.info')
    </div>
    <div role="tabpanel" class="tab-pane" id="tubes">
        @include('machine.tubes')
    </div>
    <div role="tabpanel" class="tab-pane" id="opnotes">
        @include('machine.opnotes')
    </div>
    <div role="tabpanel" class="tab-pane" id="surveys">
        @include('machine.surveys')
    </div>
    <div role="tabpanel" class="tab-pane" id="recs">
        @include('machine.recs')
    </div>
</div>
@endsection
