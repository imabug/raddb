<!-- resources/views/qa/index.blade.php -->

@extends('qa.app')
@section('content')
<h2><span class="label label-default">Active machines with survey data</span></h2>

<table class="table table-hover">
@foreach ($machines->chunk(5) as $chunk)
<tr>
@foreach ($chunk as $m)
<td><a href="{{ route('qa.show', $m->id) }}">{{ $m->description }}</a></td>
@endforeach
</tr>
@endforeach
</table>
@endsection
