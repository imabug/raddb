<!-- resources/views/machine/list_locations.blade.php -->

@extends('layouts.app')

@section('content')
{!! Charts::assets(['google']) !!}
@foreach ($calChart as $cal)
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $cal->render() !!}</p>
    </div>
</div>
@endforeach
@endsection
