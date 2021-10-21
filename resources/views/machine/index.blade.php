<!-- resources/views/machine/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory - {{ $machineStatus ?? '' }} ({{ $n ?? '' }})</h2>

<livewire:machine-list-table />

@endsection
