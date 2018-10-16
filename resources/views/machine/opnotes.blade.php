<!-- resources/views/machine/opnotes.blade.php -->

<h3><span class="label label-default">Operational Notes</span></h3>
<ol>
  @foreach ($opnotes as $opnote)
  <li>{{ $opnote->note }}</li>
  @endforeach
</ol>
@if (Auth::check())
<p><a href="{{ route('opnotes.createOpNoteFor', $machine->id) }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add operational note</a></p>
@endif
