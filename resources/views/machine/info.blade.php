<!-- resources/views/machine/info.blade.php -->

@if ($machine->machine_status == "Inactive" || $machine->machine_status == "Removed")
<h2><span class="label label-danger">{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</span></h2>
<div class="panel panel-danger">
@else
<h2><span class="label label-primary">{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</span></h2>
<div class="panel panel-primary">
@endif
    <div class="panel-heading>">
        <h3 class="panel-title">Machine Information</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
            {{-- Machine data section --}}
                <p>
                Machine ID: {{ $machine->id }} <br>
                Manufacturer: {{ $machine->manufacturer->manufacturer }} <br>
                Model: {{ $machine->model }} <br>
                Serial Number: {{ $machine->serial_number }} <br>
                Software version: {{ $machine->software_version }} <br>
                Vendor Site ID: {{ $machine->vend_site_id }} <br>
                Location: {{ $machine->location->location }} {{ $machine->room }}<br>
                Manufacture Date: {{ $machine->manuf_date }} <br>
                Install Date: {{ $machine->install_date }} <br>
                Age: {{ $machine->age }}<br>
                Status: {{ $machine->machine_status }}<br>
                Notes: {{ $machine->notes }}
                <div class="media">
                    <div class="media-right">
                    </div>
                </div>
                </p>
                @if (Auth::check())
                <p>
                    <form class="form-inline" action="{{ route('machines.destroy', $machine->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="form-group">
                            <a href="{{ route('machines.edit', $machine->id) }}" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this machine">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </p>
                @endif
            </div>
            <div class="col-md-6">
            {{-- Machine photo carousel --}}
                <div class="slider multiple-items">
                @foreach ($photos as $photo)
                    <div class="image">
                        <h3>
                            <a href="{{ $photo->getUrl() }}" target="_blank">
                            <img src="{{ $photo->getUrl() }}" width="150"></a>
                            @if (Auth::check())
                            <form class="form-inline" action="{{ route('photos.destroy', $photo->id) }}" method="post">
                                <div class="form-group">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
                                    <button type="submit" class="form-control btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this image">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </form>
                            @endif
                        </h3>
                    </div>
                @endforeach
                </div>
                @if (Auth::check())
                <form class="form-inline" action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input class="form-control" type="hidden" name="machineId" value="{{ $machine->id }}">
                        <p><label for="photoDescription">Photo description: </label><input class="form-control" type="text" id="photoDescription" name="photoDescription"></p>
                        <p><label for="photo">Upload photo: </label> <input class="form-control" type="file" id="photo" name="photo" >
                        <button class="form-control" type="submit">Add photo</button></p>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
