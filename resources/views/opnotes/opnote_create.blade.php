<!-- resources/views/opnotes/opnote_create.blade.php -->

@extends('layouts.app')

@section('content')
@if(is_null($machineId))
<h2>Add operational note</h2>
@else
<h2>Add operational note for {{ $machines->description }}</h2>
@endif

<ol>
@foreach ($opNotes as $opNote)
    <li>{{ $opNote->note }}
        <a href="{{ route('opnotes.edit', $opNote->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Edit operational note">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
    </li>
@endforeach
</ol>

<form class="form-inline" action="{{ route('opnotes.store')}}" method="post">
    <div class="form-group">
        {{ csrf_field() }}
        <p>
        @if(is_null($machineId))
        <label for="machineId">Select a machine: </label>
        <select class="form-control" name="machineId">
        @foreach ($machines as $machine)
            <option value="{{ $machine->id }}">{{ $machine->description }}</option>
        @endforeach
        </select>
        @else
        <input type="hidden" name="machineId" value="{{ $machines->id }}">
        @endif
        </p>
        <p><label for="note">Operational note</label><br>
           <textarea name="note" rows="8" cols="80" placeholder="Enter operational note"></textarea></p>
        <p><button type="submit" name="submit">Submit</button></p>
    </div>
</form>
@endsection
