<!-- resources/views/qa/survey_data_list.blade.php -->

@extends('qa.app')
@section('content')
    <h2>Available survey data for {{ $surveyData->machine->description }} ({{ $surveyData->survey->test_date }} Survey ID {{ $surveyData->id }})</h2>
@if ($surveyData->gendata)
<p><a href="{{ route('gendata.show', $surveyData->id) }}">Generator data</a></p>
@endif
@if($surveyData->collmatordata)
<p><a href="{{ route('collmatordata.show', $surveyData->id) }}"Collimator data</a></p>
@endif
@if($surveyData->radoutputdata)
<p><a href="{{ route('radoutputdata.show', $surveyData->id) }}">Radiation output data</a></p>
@endif
@if($surveyData->radsurveydata)
<p><a href="{{ route('radsurveydata.show', $surveyData->id) }}">Radiation survey data</a></p>
@endif
@if($surveyData->hvldata)
<p><a href="{{ route('hvldata.show', $surveyData->id) }}">HVL data</a></p>
@endif
@if($surveyData->fluorodata)
<p><a href="{{ route('fluorodata.show', $surveyData->id) }}">Skin entrance exposure data</a></p>
@endif
@if($surveyData->maxfluorodata)
<p><a href="{{ route('maxfluorodata.show', $surveyData->id) }}">Max skin entrance exposure data</a><p>
@endif
@if($surveyData->receptorentrance)
<p><a href="{{ route('receptorentrance.show', $surveyData->id) }}">Image receptor entrance exposure data</a></p>
@endif
@endsection