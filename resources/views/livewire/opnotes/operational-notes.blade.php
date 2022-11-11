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
    <select id="selectedMachine" name="selectedMachine" class="form-control" aria-label="Select a machine" wire:model="selectedMachine">
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
              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this tube">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
              </button>
            </a>
            <button wire:click="deleteNote({{$o->id}})" class="btn btn-danger btn-sm" role="button" data-toggle="tooltip" title="Delete op note">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
              </svg>
          </li>
        @endforeach
      </ol>
    @endif
  </div>
  <div class="row">
    <span class="input-group-text">Operational note</span>
    <textarea wire:model="note" name="note" rows="8" cols="80" placeholder="Enter operational note" aria-label="Enter operational note"></textarea>
    <div>
      <button wire:click="addNote({{$selectedMachine}}, '{{$note}}')" type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add operational note">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
          <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        Add operational note
      </button>
    </div>
  </div>
</div>
