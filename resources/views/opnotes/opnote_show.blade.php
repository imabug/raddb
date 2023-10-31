{{-- resources/views/opnotes/opnote_show.blade.php --}}
{{-- Used by the show() method in OpNoteController --}}
@extends('layouts.app')

@section('content')
  <h2>Operational notes for <a href="{{route('machines.show', $machine->id) }}">{{ $machine->description }}</a></h2>
  {{-- Use App\Livewire\Opnotes\ShowOpnotes Livewire component to display existing operational notes --}}
  <div>
    <livewire:opnotes.show-opnotes :machineId="$machine->id" />
  </div>
  <form class="form-inline" action="{{ route('opnotes.store')}}" method="post">
    @csrf
    <input type="hidden" name="machineId" value="{{$machine->id}}">
    <div class="row">
      <div class="col input-group mb-3">
        <textarea name="note" rows="8" cols="80" placeholder="Enter operational note" aria-label="Enter operational note"></textarea>
      </div>
    </div>
    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
  </form>
@endsection
