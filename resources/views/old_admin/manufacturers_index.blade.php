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
			<td><a href="{{ route('manufacturers.edit', $manufacturer->id) }}">{{ $manufacturer->manufacturer }}</a></td>
			<td>
				<form class="form-inline" action="{{ route('manufacturers.destroy', $manufacturer->id) }}" method="post">
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
<p>
<form class="form-inline" action="{{ route('manufacturers.store') }}" method="POST">
	<div class="form-group">
		{{ csrf_field() }}
		<label for="manufacturer">New Manufacturer:</label> <input type="TEXT" class="form-control" id="manufacturer" name="manufacturer" size="20" placeholder="Manufacturer" >
		<button class="btn btn-default" type="SUBMIT">Add manufacturer</button>
	</div>
</form>
</p>
@endsection
