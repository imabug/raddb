{{-- resources/views/machine/opnotes.blade.php --}}
{{-- Used in resources/views/machine/detail.blade.php --}}
<h3><span class="label label-default">Operational Notes</span></h3>
<ol>
  @foreach ($opnotes as $opnote)
    <li>{{ $opnote->note }}</li>
  @endforeach
</ol>
@if (Auth::check())
  <p><a href="{{ route('opnotes.createOpNoteFor', $machine->id) }}">
    <x-glyphs.plus />
    Add operational note</a></p>
@endif
