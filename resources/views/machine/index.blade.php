{{-- resources/views/machine/index.blade.php --}}
{{-- Used by the index() method in MachineController --}}
@extends('layouts.app')

@section('content')
  <h2>Equipment Inventory</h2>

{{-- Use App\Http\Livewire\MachineListTable component to display the list of machines --}}
<livewire:machine-list-table />

@endsection
