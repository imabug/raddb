<!-- resources/views/opnotes/opnote_show.blade.php -->

@extends('layouts.app')

@section('content')
  <h2>Operational notes for <a href="{{route('machines.show', $machine->id) }}">{{ $machine->description }}</a></h2>
  <ol>
    @foreach ($opNotes as $opNote)
      <li>{{ $opNote->note }}
        <a href="{{ route('opnotes.edit', $opNote->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Edit operational note">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this tube">
            <x-glyphs.pencil />
          </button>
        </a>
      </li>
    @endforeach
  </ol>
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
