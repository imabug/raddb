<!-- resources/views/machine/list_locations.blade.php -->

@extends('layouts.app')

@section('content')
{!! Charts::assets(['google']) !!}
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $calChart->render() !!}</p>
    </div>
</div>
@endsection
