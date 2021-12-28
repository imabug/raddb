@extends('layouts.app')

@section('content')
  <div class="row">
    <h2>Operational notes</h2>
    <div class="col input-group mb-3"
      <form wire:submit.prevent="getNotes">
        <span class="input-group-text">Machine:</span>
        <select wire:model="m">
          <option>Select a machine</option>
          @foreach ($machine as $m)
            <option value="{{$m->id}}">{{$m->description}}</option>
          @endforeach
        </select>
        <button type="submit">Get Notes</button>
      </form>
    </div>
    @if(!is_null($opNotes))
    <div>
      <ol>
      @foreach ($opNotes as $o)
        <li wire:key="{{$o->id}}">$o->note</li>
      @endforeach
      </ol>
    </div>
    @endif
  </div>
@endsection
