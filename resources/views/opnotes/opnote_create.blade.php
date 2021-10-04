<!-- resources/views/opnotes/opnote_create.blade.php -->

@extends('layouts.app')

@section('content')
@if(is_null($machineId))
<h2>Add operational note</h2>
@else
<h2>Add operational note for <a href="{{route('machines.show', $machineId) }}">{{ $machines->description }}</a></h2>
@endif

<ol>
@if(!is_null($opNotes))
@foreach ($opNotes as $opNote)
    <li>{{ $opNote->note }}
        <a href="{{ route('opnotes.edit', $opNote->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Edit operational note">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this tube">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
          </button>
        </a>
    </li>
@endforeach
@endif
</ol>

<form class="form-inline" action="{{ route('opnotes.store')}}" method="post">
@csrf
  <div class="row">
     <div class="col input-group mb-3">
@if(is_null($machineId))
       <span class="input-group-text">Select a machine: </span>
       <select class="form-control" name="machineId" aria-label="Select machine">
@foreach ($machines as $machine)
         <option value="{{ $machine->id }}">{{ $machine->description }}</option>
@endforeach
       </select>
@else
       <input type="hidden" name="machineId" value="{{ $machines->id }}">
       <span class="input-group-text">Machine:</span>
       <input type="text" name="machineID" value="{{ $machines->description }}" readonly>
@endif
     </div>
  </div>
  <div class="row">
     <div class="col input-group mb-3">
       <span class="input-group-text">Operational note</span>
       <textarea name="note" rows="8" cols="80" placeholder="Enter operational note" aria-label="Enter operational note"></textarea>
     </div>
  </div>
  <button class="btn btn-primary" type="submit" name="submit">Submit</button>
</form>
@endsection
