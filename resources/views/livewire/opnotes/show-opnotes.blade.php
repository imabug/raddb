<div>
  @if(!is_null($opNotes))
    <ol class="list-group list-group-numbered">
      @foreach ($opNotes as $opNote)
        <li class="list-group-item">{{ $opNote->note }}
          <a href="{{ route('opnotes.edit', $opNote->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Edit operational note">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this tube">
              <x-glyphs.pencil />
            </button>
          </a>
        </li>
      @endforeach
    </ol>
  @endif
</div>
