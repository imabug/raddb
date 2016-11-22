<!-- resources/views/admin/tester_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Testers</h2>

<table class="table">
	<tbody>
@foreach ($testers->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $tester)
			<td>{{ $tester->id }}</td>
			<td>{{ $tester->name }}</td>
			<form action="/admin/testers/{{ $tester->id }}/edit" method="POST">
				<button type="submit">Edit</button>
			</form>
		@endforeach
		</tr>
@endforeach
	</tbody>
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
