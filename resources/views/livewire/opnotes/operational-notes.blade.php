<div>
  <h2>Operational notes</h2>
  <div class="col input-group mb-3"
    <form class="form-inline" wire:submit.prevent="getNotes">
      @csrf
      <span class="input-group-text">Machine:</span>
      <select id="mNotes" name="mNotes" class="form-select" aria-label="Select a machine" wire:model="mNotes">
        <option>Select a machine</option>
        @foreach ($machine as $m)
          <option value="{{$m->id}}">{{$m->description}}</option>
        @endforeach
      </select>
      <button>Get Notes</button>
    </form>
    <p>{{$mNotes}}</p>
  </div>
  @if(!is_null($opNotes))
    <ol>
      @foreach ($opNotes as $o)
        <li wire:key="{{$o->id}}">$o->note</li>
      @endforeach
    </ol>
  @endif
</div>
