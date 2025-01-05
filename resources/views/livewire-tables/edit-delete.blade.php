{{-- TODO: Edit/Delete buttons seem very kludgy.  Need to fix this --}}
  <form class="row gy-1 gx-2 align-items-center" action="{{ route('machines.destroy', $row->id) }}" method="post">
    @csrf
    @method('DELETE')
    <div class="col-auto">
      <a href="{{ route('machines.edit', $row->id) }}" data-toggle="tooltip" title="Modify this machine">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this machine">
          <x-glyphs.pencil />
        </button>
      </a>
      <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove this machine">
        <x-glyphs.trashcan />
      </button>
    </div>
  </form>
