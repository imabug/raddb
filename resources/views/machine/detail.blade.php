<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Machine Information</h2>
<h2>{{ $machine->modality->modality }}: {{ $machine->description }} ({{ $machine->vend_site_id }})</h2>
<h3>Machine Information</h3>
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

<h3>Tube Information</h3>
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
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Operational Notes</h3>
<ol>
  @foreach ($opnotes as $opnote)
  <li>{{ $opnote->note }}</li>
  @endforeach
</ol>

<h3>Survey Information</h3>
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
            <td>{{ $survey->id }}</td>
            <td>{{ $survey->test_date }}</td>
            <td>{{ $survey->type->test_type }}</td>
            <td>{{ $survey->accession }}</td>
            <td>{{ $survey->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Survey Recommendations</h3>
<table class="table">
    <thead>
        <tr>
            <th>Survey ID</th>
            <th>Recommendation</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recommendations as $rec)
        <tr>
            <td>{{ $rec->survey_id }}</td>
            <td>{{ $rec->recommendation }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
