<!-- resources/views/opnotes/opnote_show.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Operational notes for {{ $machine->description }}</h2>
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
        <input type="hidden" name="machineId" value="$machine->id">
        <p><textarea name="note" rows="8" cols="80" placeholder="Enter operational note"></textarea></p>
        <p><button type="submit" name="submit">Submit</button></p>
    </div>
</form>
@endsection
