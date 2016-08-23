<!-- resources/views/layouts/debug.blade.php -->

@extends('layouts.app')

@section('content')
<pre>{{ print_r($machine) }}</pre>
<pre>{{ print_r($tubes) }}</pre>
<pre>{{ print_r($surveys )}}</pre>

<h2>Machine Information</h2>
<h2>{{ $machine->modality->modality }}: {{ $machine->description }} ( {{ $machine->vend_site_id }}</h2>
<h3> machine Information</h3>
<p>
Machine ID: {{ $machine->id }} <br />
Model: {{ $machine->model }} <br />
Serial Number: {{ $machine->serial_number }} <br />
Vendor Site ID: {{ $machine->vend_site_id }} <br />
Location: {{ $machine->location->location }} <br />
Manufacture Date: {{ $machine->manuf_date }} <br />
Install Date: {{ $machine->install_date }} <br />
Age: <br />
Notes: {{ $machine->notes }}
</p>

<table>
@foreach ($tubes as $tube)
    <tr>
        <td>{{ $tube->id }}</td>
        <td>{{ $tube->housing_manuf->manufacturer }}{{ $tube->housing_model }}</td>
        <td>{{ $tube->housing_sn }}</td>
        <td>{{ $tube->insert_manuf->manufacturer }}{{ $tube->insert_model }}</td>
        <td>{{ $tube->insert_sn }}</td>
        <td>{{ $tube->lfs }} / {{ $tube->mfs }} / {{ $tube->sfs }}</td>
        <td>{{ $tube->manuf_date }}</td>
        <td>&nbsp;</td>
        <td>{{ $tube->notes }}</td>
    </tr>
@endforeach
</table>

<h3>Survey Information</h3>
<table>
    <tr>
        <th>Survey ID</th>
        <th>Test Date</th>
        <th>Test Type</th>
        <th>Accession</th>
        <th>Notes</th>
    </tr>
    @foreach ($surveys as $survey)
    <tr>
        <td>{{ $survey->id }}</td>
        <td>{{ $survey->test_date }}</td>
        <td>{{ $survey->accession }}</td>
        <td>{{ $survey->notes }}</td>
    </tr>
    @endforeach
</table>

@endsection