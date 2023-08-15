
{{-- resources/views/machine/info.blade.php --}}
{{-- Used in resources/views/machine/detail.blade.php --}}
<h3><span class="label label-default">Machine Information</span></h3>
<div class="row">
  <div class="col-md-6">
    {{-- Machine data section --}}
    <p>
      Machine ID: {{ $machine->id }} <br>
      Status: {{ $machine->machine_status }}<br>
      Location: {{ $machine->location->location }} {{ $machine->room }}<br>
      Manufacturer: {{ $machine->manufacturer->manufacturer }} <br>
      Model: {{ $machine->model }} <br>
      Serial Number: {{ $machine->serial_number }} <br>
      Software version: {{ $machine->software_version }} <br>
      Vendor Site ID: {{ $machine->vend_site_id }} <br>
      Manufacture Date: {{ $machine->manuf_date }} <br>
      Install Date: {{ $machine->install_date }} <br>
      PACS Station Name: {{ $machine->pacs_station }}<br>
      Age: {{ $machine->age }}<br>
      Notes: {{ $machine->notes }}
      <div class="media">
        <div class="media-right">
        </div>
      </div>
    </p>
    <p>
	  <form class="row gy-1 gx-2 align-items-center" action="{{ route('machines.destroy', $machine->id) }}" method="post">
        @csrf
        @method('DELETE')
		<div class="col-auto">
          <a href="{{ route('machines.edit', $machine->id) }}" data-toggle="tooltip" title="Modify this machine">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Modify this machine">
              <x-glyphs.pencil />
            </button>
          </a>
          <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove this machine">
            <x-glyphs.trashcan />
          </button>
		</div>
	  </form>
    </p>
  </div>
  <div class="col-md-6">
    {{-- Machine photo carousel --}}
    <div class="slider multiple-items">
      @foreach ($photos as $photo)
        <div class="image">
          <h3>
            <a href="{{ $photo->getUrl() }}" target="_blank">
              <img src="{{ $photo->getUrl() }}" width="150"></a>
              <form class="form-inline" action="{{ route('photos.destroy', $photo->id) }}" method="post">
                <div class="form-group">
                  @csrf
                  @method('DELETE')
                  <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
                  <button type="submit" class="form-control btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this image">
                    <x-glyphs.trashcan />
                  </button>
                </div>
              </form>
          </h3>
        </div>
      @endforeach
    </div>
    <form class="form-inline" action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
      <div class="row">
        <div class="col input-group mb-3">
          <span class="input-group-text">Upload photo:</span>
          <input class="form-control" type="file" id="photo" name="photo" aria-label="Select photo for upload">
        </div>
      </div>
      <button class="btn btn-primary" type="submit">Add photo</button></p>
    </form>
  </div>
</div>
