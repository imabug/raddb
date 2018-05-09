<!-- resources/views/ctdailyqc/ctdailyqc_show.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Daily QC records for {{ $ctScanner->description }} ({{ $numRecords }} records)</h2>
<table class="table table-striped">
    <thead>
        <th>Date</th>
        <th>Scan mode</th>
        <th>Water HU</th>
        <th>Limit</th>
        <th>Water SD</th>
        <th>Limit</th>
        <th>Artifacts?</th>
        <th>Initials</th>
        <th>Notes</th>
    </thead>
    <tbody>
        <form class="form-inline" action="{{route('ctdailyqc.store')}}" method="POST">
        	<div class="form-group">
        		{{ csrf_field() }}
                    <tr>
                    <input type="hidden" name="machine_id" value="{{ $ctScanner->id }}">
                    <td rowspan=2><input class="form-control" type="date" id="qcdate" name="qcdate" size="10" required></td>
                    <td><input type="text" class="form-control" name="scan_type[]" value="Axial" readonly tabindex="-1"></td>
                    <td><input type="text" class="form-control" name="water_hu[]" required></td>
                    <td></td>
                    <td><input type="text" class="form-control" name="water_sd[]" required></td>
                    <td></td>
                    <td>
                        <select class="form-control" name="artifacts[]" >
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" name="initials" required></td>
                    <td rowspan="2">
                        <input type="text" class="form-control" name="notes">
                        <button class="form-control" type="SUBMIT">Add QC record</button>
                    </td>
                </tr>
                <tr>
                <td><input type="text" class="form-control" name="scan_type[]" value="Helical" readonly tabindex="-1"></td>
                <td><input type="text" class="form-control" name="water_hu[]" required></td>
                <td></td>
                <td><input type="text" class="form-control" name="water_sd[]" required></td>
                <td></td>
                <td>
                    <select class="form-control" name="artifacts[]" >
                        <option value="N">N</option>
                        <option value="Y">Y</option>
                    </select>
                </td>
            </tr>
            </div>
        </form>
        @foreach ($ctQcRecords as $ctQcRec)
        <tr>
            <td>{{ $ctQcRec->qcdate}}</td>
            <td>{{ $ctQcRec->scan_type}}</td>
            @if (abs($ctQcRec->water_hu) <= 7 )
            <td class="success">{{ $ctQcRec->water_hu }}</td>
            <td class="success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
            @else
            <td class="danger">{{ $ctQcRec->water_hu }}</td>
            <td class="danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>
            @endif
            @if (abs($ctQcRec->water_sd) <= 20)
            <td class="success">{{ $ctQcRec->water_sd }}</td>
            <td class="success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
            @else
            <td class="danger">{{ $ctQcRec->water_sd }}</td>
            <td class="danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>
            @endif
            @if ($ctQcRec->artifacts == 'N')
            <td class="success">
            @else
            <td class="danger">
            @endif
                {{ $ctQcRec->artifacts }}
            </td>
            <td>{{ $ctQcRec->initials }}</td>
            <td>{{ $ctQcRec->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
