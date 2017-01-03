<!-- resources/views/admin/manufacturer_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Manufacturers</h2>
<p>Click a manufacturer to edit</p>
<table class="table">
	<tbody>
@foreach ($manufacturers->chunk(3) as $chunk )
		<tr>
		@foreach ($chunk as $manufacturer)
			<td>{{ $manufacturer->id }}</td>
			<td><a href="/admin/manufacturers/{{ $manufacturer->id }}/edit">{{ $manufacturer->manufacturer }}</a></td>
			<td>
				<form class="form-inline" action="/admin/manufacturers/{{ $manufacturer->id }}" method="post">
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

<h2>Add a Manufacturer</h2>
<!-- Add a new manufacturer -->
<form class="form-inline" action="/admin/manufacturers" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="manufacturer">New Manufacturer:</label> <input type="TEXT" class="form-control" id="manufacturer" name="manufacturer" size="20" placeholder="Manufacturer" >
		<button class="btn btn-default" type="SUBMIT">Add manufacturer</button> / <a href="/">Main</a>
	</div>
</form>

@endsection
