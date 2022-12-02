{{-- resources/views/inc/untested.blade.php --}}
{{-- Used in resources/views/index.blade.php by HomeController --}}
<h2><span class="label label-default">Surveys to be scheduled ({{ $remain }}/{{ $total }})</span></h2>
<p>Click a link to schedule a survey for a unit</p>

<table class="table table-bordered table-sm">
	<tbody>
@foreach ($machinesUntested->chunk(5) as $chunk )
		<tr>
		@foreach ($chunk as $machine)
			<td><a href="{{ route('surveys.createSurveyFor', $machine->id)}}">{{ $machine->description }}</a></td>
		@endforeach
		</tr>
@endforeach
	</tbody>
</table>
