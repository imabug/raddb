<!-- resources/views/admin/manufacturer_index.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Manufacturers</h2>

<table class="table">
	<tbody>
@foreach ($manufacturers->chunk(2) as $chunk )
		<tr>
		@foreach ($chunk as $manufacturer)
			<td>{{ $manufacturer->id }}</td>
			<td>{{ $manufacturer->manufacturer }}</td>
			<td>
				<form action="/admin/manufacturers/{{ $manufacturer->id }}/edit" method="POST">
					<button type="submit">Edit</button>
				</form>
			</td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>

<h2>Add a Manufacturer</h2>
<!-- Add a new manufacturer -->
<form action="/admin/manufacturers" method="POST">
	{{ csrf_field() }}
New Manufacturer: <input type="TEXT" name="manufacturer" size="20" />
<button type="SUBMIT">Add manufacturer</button> / <a href="/">Main</a>
</form>

@endsection
