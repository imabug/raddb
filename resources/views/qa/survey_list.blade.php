<!-- resources/views/qa/survey_list.blade.php -->

@extends('qa.app')
@section('content')
<h2>Survey data listing for {{ $machine->description }}</h2>

<table class="table table-hover">
@foreach ($surveyData->chunk(5) as $chunk)
<tr>
@foreach ($chunk as $s)
<td>Survey ID: <a href="{{ route('qa.surveyDataList', $s->id) }}">{{ $s->id }}</a><br />Date: {{ $s->survey->test_date }}</td>
@endforeach
</tr>
@endforeach
</table>
@endsection