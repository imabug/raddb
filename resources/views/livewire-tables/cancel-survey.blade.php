{{-- TODO: Edit/Delete buttons seem very kludgy.  Need to fix this --}}
@if(Auth::check())
  <form class=""row gy-1 gx-2 align-items-center"  action="{{ route('surveys.cancel', $row->id) }}" method="POST" >
    @csrf
    <div class="col-auto">
      <button type="submit" class="btn btn-danger btn-sm" role="button" data-toggle="tooltip" title="Cancel this survey">
        <x-glyphs.trashcan />
      </button>
    </div>
  </form>
@endif
