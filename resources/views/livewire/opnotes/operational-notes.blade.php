<div>
  <h2>Operational notes</h2>
  <div class="col input-group mb-3"
    <form class="form-inline">
      <span class="input-group-text">Machine:</span>
      <select id="selectedMachine" name="selectedMachine" class="form-select" aria-label="Select a machine" wire:model="selectedMachine">
        <option>Select a machine</option>
        @foreach ($machines as $m)
          <option value="{{$m->id}}">{{$m->description}}</option>
        @endforeach
      </select>
      <button type="submit" wire:click="getNotes">Get Notes</button>
    </form>
  </div>
  <div>
  @if(!is_null($opNotes))
    <ol>
      @foreach ($opNotes as $o)
        <li>{{$o->note}}</li>
      @endforeach
    </ol>
  @endif
  </div>
</div>
