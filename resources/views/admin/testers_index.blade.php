<!-- resources/views/admin/tester_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Testers</h2>

<table>
@foreach ($testers->chunk(2) as $chunk )
	<tr>
	@foreach ($chunk as $tester)
		<td>{{ $tester->id }}</td>
		<td>{{ $tester->name }}</td>
	@endforeach
	</tr>
@endforeach
</table>

<h2>Add a Tester</h2>
<!-- Add a new tester -->
<form action="/admin/testers" method="POST">
	{{ csrf_field() }}
Name: <input type="TEXT" name="name" size="25" />
Initials: <input type="TEXT" name="initials" size="3" /> 
<button type="SUBMIT">Add tester</button> / <a href="/">Main</a>
</form>
@endsection
