<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Machine Information</h2>
<h2><span class="label label-primary">{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</span></h2>
<div class="panel panel-primary">
    <div class="panel-heading>">
        <h3 class="panel-title">Machine Information</h3>
    </div>
    <div class="panel-body">
        <p>
        Machine ID: {{ $machine->id }} <br />
        Model: {{ $machine->model }} <br />
        Serial Number: {{ $machine->serial_number }} <br />
        Vendor Site ID: {{ $machine->vend_site_id }} <br />
        Location: {{ $machine->location->location }} <br />
        Manufacture Date: {{ $machine->manuf_date }} <br />
        Install Date: {{ $machine->install_date }} <br />
        Age: {{ $machine->age }}<br />
        Notes: {{ $machine->notes }}
        </p>
        <p>
            <form class="form-inline" action="/machines/{{ $machine->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <a href="/machines/{{ $machine->id }}/edit" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this machine">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this machine">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </p>
    </div>
</div>
<h3><span class="label label-default">Tube Information</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Tube ID</th>
            <th>Housing</th>
            <th>Housing SN</th>
            <th>Insert</th>
            <th>Insert SN</th>
            <th>Focal Spots</th>
            <th>Manuf Date</th>
            <th>Age</th>
            <th>Notes</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tubes as $tube)
        <tr>
            <td>{{ $tube->id }}</td>
            <td>{{ $tube->housing_manuf->manufacturer }} {{ $tube->housing_model }}</td>
            <td>{{ $tube->housing_sn }}</td>
            <td>{{ $tube->insert_manuf->manufacturer }} {{ $tube->insert_model }}</td>
            <td>{{ $tube->insert_sn }}</td>
            <td>{{ $tube->lfs }} / {{ $tube->mfs }} / {{ $tube->sfs }}</td>
            <td>{{ $tube->manuf_date }}</td>
            <td>{{ $tube->age }}</td>
            <td>{{ $tube->notes }}</td>
			<td>
				<form class="form-inline" action="/tubes/{{ $machine->id }}" method="post">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
                    <a href="/tubes/{{ $tube->id }}/edit" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Modify this tube">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    				</a>
                    <a href="/tubes/{{ $machine->id }}/create" class="btn btn-default btn-xs" role="button" data-toggle="tooltip" title="Add new tube">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Remove this tube">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
				</form>
			</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3><span class="label label-default">Operational Notes</span></h3>
<ol>
  @foreach ($opnotes as $opnote)
  <li>{{ $opnote->note }}</li>
  @endforeach
</ol>

<h3><span class="label label-default">Survey Information</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Survey ID</th>
            <th>Test Date</th>
            <th>Test Type</th>
            <th>Accession</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($surveys as $survey)
        <tr>
            <td><a href="/recommendations/{{ $survey->id }}">{{ $survey->id }}</a></td>
            <td>{{ $survey->test_date }}</td>
            <td>{{ $survey->type->test_type }}</td>
            <td>{{ $survey->accession }}</td>
            <td>{{ $survey->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3><span class="label label-default">Survey Recommendations</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Survey ID</th>
            <th>Recommendation</th>
            <th>Resolved</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recommendations as $rec)
        <tr>
            <td><a href="/recommendations/{{ $rec->survey_id }}">{{ $rec->survey_id }}</a></td>
            <td>{{ $rec->recommendation }}</td>
            <td>
@if($rec->resolved)
    <span class="glyphicon glyphicon-ok" aria-hidden-"true"></span>
@endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
