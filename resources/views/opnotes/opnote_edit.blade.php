<!-- resources/views/opnotes/opnote_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit operational note</h2>
<form class="form-inline" action="{{ route('opnotes.update')}}" method="post">
    <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="opnote_id" value="{{ $opnote->id }}">
        <textarea name="note" rows="8" cols="80">{{ $opnote->note }}</textarea>
        <button type="submit" name="submit">Submit</button>
    </div>
</form>
@endsection
