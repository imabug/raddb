<!-- resources/views/opnotes/opnote_create.blade.php -->

@extends('layouts.app')

@section('content')
  @if(is_null($machineId))
    <h2>Add operational note</h2>
  @else
    <h2>Add operational note for <a href="{{route('machines.show', $machineId) }}">{{ $machines->description }}</a></h2>
  @endif

  <div>
    <livewire:opnotes.show-opnotes :machineId="$machineId" />
  </div>
  <div>
    <form class="form-inline" action="{{ route('opnotes.store')}}" method="post">
      @csrf
      <div class="row">
        <div class="col input-group mb-3">
          @if(is_null($machineId))
            <span class="input-group-text">Select a machine: </span>
            <select class="form-control" name="machineId" aria-label="Select machine" wire:click="setMachineId">
              @foreach ($machines as $machine)
                <option value="{{ $machine->id }}">{{ $machine->description }}</option>
              @endforeach
            </select>
          @else
            <input type="hidden" name="machineId" value="{{ $machines->id }}">
            <span class="input-group-text">Machine:</span>
            <input type="text" name="machineID" value="{{ $machines->description }}" readonly>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col input-group mb-3">
          <span class="input-group-text">Operational note</span>
          <textarea name="note" rows="8" cols="80" placeholder="Enter operational note" aria-label="Enter operational note"></textarea>
        </div>
      </div>
      <button class="btn btn-primary" type="submit" name="submit">Submit</button>
    </form>
  </div>
@endsection
