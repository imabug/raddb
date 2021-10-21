<!-- resources/views/machine/index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Equipment Inventory - {{ $machineStatus ?? '' }} ({{ $n ?? '' }})</h2>

{{-- Use the MachineListTable Livewire component to display the list of machines --}}
<livewire:machine-list-table />

@endsection
