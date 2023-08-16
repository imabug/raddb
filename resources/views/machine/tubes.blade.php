{{-- resources/views/machine/tubes.blade.php --}}
{{-- Used in resources/views/machine/detail.blade.php --}}
<h3><span class="label label-default">Tube Information</span></h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Tube ID</th>
      <th scope="col">Housing</th>
      <th scope="col">Housing SN</th>
      <th scope="col">Insert</th>
      <th scope="col">Insert SN</th>
      <th scope="col">Focal Spots</th>
      <th scope="col">Manuf Date</th>
      <th scope="col">Age</th>
      <th scope="col">Status</th>
      <th scope="col">Notes</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tubes as $tube)
      <tr>
        <th scope="row">{{ $tube->id }}</th>
        <td>{{ $tube->housing_manuf->manufacturer }} {{ $tube->housing_model }}</td>
        <td>{{ $tube->housing_sn }}</td>
        <td>{{ $tube->insert_manuf->manufacturer }} {{ $tube->insert_model }}</td>
        <td>{{ $tube->insert_sn }}</td>
        <td>{{ $tube->lfs }} / {{ $tube->mfs }} / {{ $tube->sfs }}</td>
        <td>{{ $tube->manuf_date }}</td>
        <td>{{ $tube->age }}</td>
        <td>{{ $tube->tube_status }}</td>
        <td>{{ $tube->notes }}</td>
		<td>
		  <form class="row gy-1 gx-2 align-items-center" action="{{ route('tubes.destroy', $tube->id) }}" method="post">
            @csrf
            @method('DELETE')
			<div class="col-auto">
              <a href="{{ route('tubes.edit', $tube->id) }}" data-toggle="tooltip" title="Modify this tube">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this tube">
                  <x-glyphs.pencil />
                </button>
              </a>
              <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove this machine">
                <x-glyphs.trashcan />
              </button>
			</div>
		  </form>
		</td>
      </tr>
    @endforeach
  </tbody>
</table>
<p>
  <a href="{{ route('tubes.createTubeFor', $machine->id) }}">
    <x-glyphs.plus />Add x-ray tube
  </a>
</p>
