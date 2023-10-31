<div>
  <h2>Operational notes</h2>
  <div class="row">
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
  </div>
  <div class="row">
    <span class="input-group-text">Machine: {{$selectedMachine}}</span>
    <select id="selectedMachine" name="selectedMachine" class="form-control" aria-label="Select a machine" wire:model.live="selectedMachine">
      @foreach ($machines as $m)
        <option value="{{$m->id}}">{{$m->description}}</option>
      @endforeach
    </select>
  </div>
  <div class="row">
    @if(!is_null($opNotes))
      <ol class="list-group list-group-numbered">
        @foreach ($opNotes as $o)
          <li class="list-group-item">{{$o->note}}
            <a href="{{ route('opnotes.edit', $o->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Edit operational note">
              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit operational note">
                <x-glyphs.pencil />
              </button>
            </a>
            <button wire:click="deleteNote({{$o->id}})" class="btn btn-danger btn-sm" role="button" data-toggle="tooltip" title="Delete operational note">
              <x-glyphs.trashcan />
          </li>
        @endforeach
      </ol>
    @endif
  </div>
  <div class="row">
    <span class="input-group-text">Operational note</span>
    <textarea wire:model.live="note" name="note" rows="8" cols="80" placeholder="Enter operational note" aria-label="Enter operational note"></textarea>
    <div>
      <button wire:click="addNote({{$selectedMachine}}, '{{$note}}')" type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add operational note">
        <x-glyphs.plus />Add operational note
      </button>
    </div>
  </div>
</div>
