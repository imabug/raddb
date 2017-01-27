<!-- resources/views/opnotes/opnote_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit operational note</h2>
<form class="form-inline" action="{{ route('opnotes.update', $opNote->id) }}" method="post">
    <div class="form-group">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <p><textarea name="note" rows="8" cols="80">{{ $opNote->note }}</textarea></p>
        <p><button type="submit" name="submit">Submit</button></p>
    </div>
</form>
@endsection
