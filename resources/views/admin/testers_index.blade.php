<!-- resources/views/admin/tester_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Testers</h2>
<p>Click on a name to edit</p>
<table class="table">
	<tbody>
@foreach ($testers->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $tester)
			<td>{{ $tester->id }}</td>
			<td><a href="{{ route('testers.edit', $tester->id) }}">{{ $tester->name }}</a></td>
			<td>
				<form class="form-inline" action="{{ route('testers.destroy', $tester->id) }}" method="post">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit" class="btn btn-danger btn-xs">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</form>
			</td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Tester</h2>
<!-- Add a new tester -->
<p>
<form class="form-inline" action="{{ route('testers.store') }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="name">Name:</label> <input type="TEXT" class="form-control" id="name" name="name" size="25" >
		<label for="initials">Initials:</label> <input type="TEXT" class="form-control" id="initials" name="initials" size="3" >
		<button type="SUBMIT" class="btn btn-default">Add tester</button>
	</div>
</form>
</p>
@endsection
