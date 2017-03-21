<!-- resources/views/index.blade.php -->

@extends('layouts.app')

@section('content')
<ul class="nav nav-pills" role="tablist">
    <li role="presentation" class="active"><a href="#survey_schedule" aria-controls="survey_schedule" role="tab" data-toggle="pill">Survey Schedule</a></li>
    <li role="presentation"><a href="#pending" aria-controls="pending" role="tab" data-toggle="pill">Pending</a></li>
    <li role="presentation"><a href="#untested" aria-controls="untested" role="tab" data-toggle="pill">Untested</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="survey_schedule">
        @include('inc.survey_schedule')
    </div>
    <div role="tabpanel" class="tab-pane" id="pending">
        @include('inc.pending')
    </div>
    <div role="tabpanel" class="tab-pane" id="untested">
        @include('inc.untested')
    </div>
</div>
@endsection
