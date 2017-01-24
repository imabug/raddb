<!-- resources/views/dashboard/survey_graph.blade.php -->
@extends('layouts.app')
@section('content')
<h2>Monthly survey count</h2>
<p>
<form class="form-inline" action="{{route('dashboard.surveyGraph')}}" method="get">
    <label for="yr">Select year: </label>
    <select class="form-group" name="yr">
        @foreach ($years as $yr)
        <option value="{{ $yr->years }}">{{ $yr->years }}</option>
        @endforeach
    </select>
    <button type="submit" name="submit">Submit</button>
</form>
</p>
{!! Charts::assets() !!}
{!! $yearChart->render() !!}
{!! $allYears->render() !!}
@endsection
