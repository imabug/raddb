{{-- TODO: Edit/Delete buttons seem very kludgy.  Need to fix this --}}
@if(Auth::check())
  <a href="{{ route('surveys.edit', $row->id) }}" class="btn btn-default btn-sm" role="button" data-toggle="tooltip" title="Modify this survey">
    <x-glyphs.pencil />
  </a>
  @endif
