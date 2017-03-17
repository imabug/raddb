<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Machine Information</h2>

@include('machine.info')
@include('machine.tubes')
@include('machine.opnotes')
@include('machine.surveys')
@include('machine.recs')

@endsection
