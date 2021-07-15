<!-- resources/views/opnotes/opnote_edit.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Edit operational note</h2>
<form class="form-inline" action="{{ route('opnotes.update', $opNote->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="row">
     <div class="col input-group mb-3">
        <textarea name="note" rows="8" cols="80" aria-label="Edit operational note">{{ $opNote->note }}</textarea>
     </div>
    </div>
    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
</form>
@endsection
