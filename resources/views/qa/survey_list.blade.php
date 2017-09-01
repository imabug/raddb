<!-- resources/views/qa/survey_list.blade.php -->

@extends('qa.app')
@section('content')
<h2>Survey data listing for {{ $machine->description }}</h2>

<table class="table table-hover">
@foreach ($surveyData->chunk(5) as $chunk)
<tr>
@foreach ($chunk as $s)
<td>
Survey ID: {{ $s->id }}<br />Date: {{ $s->survey->test_date }}
<ul>
@if ($s->gendata)
<li><a href="{{ route('gendata.show', $s->id) }}">Generator data</a></li>
@endif
@if($s->collmatordata)
<li><a href="{{ route('collmatordata.show', $s->id) }}"Collimator data</a></li>
@endif
@if($s->radoutputdata)
<li><a href="{{ route('radoutputdata.show', $s->id) }}">Radiation output data</a></li>
@endif
@if($s->radsurveydata)
<li><a href="{{ route('radsurveydata.show', $s->id) }}">Radiation survey data</a></li>
@endif
@if($s->hvldata)
<li><a href="{{ route('hvldata.show', $s->id) }}">HVL data</a></p>
@endif
@if($s->fluorodata)
<li><a href="{{ route('fluorodata.show', $s->id) }}">Skin entrance exposure data</a></li>
@endif
@if($s->maxfluorodata)
<li><a href="{{ route('maxfluorodata.show', $s->id) }}">Max skin entrance exposure data</a><li>
@endif
@if($s->receptorentrance)
<li><a href="{{ route('receptorentrance.show', $s->id) }}">Image receptor entrance exposure data</a></li>
@endif
</ul>
</td>
@endforeach
</tr>
@endforeach
</table>
@endsection