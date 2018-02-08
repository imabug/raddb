<!-- resources/views/ctdailyqc/ctdailyqc_create.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Add a machine</h2>

<form class="form-inline" action="{{route('ctdailyqcrecord.store')}}" method="POST">
	<div class="form-group">

		{{ csrf_field() }}
		<p><label for="scanner">Scanner:</label>
		<select id="scanner" name="machine_id" size="1" class="form-control" autofocus>
			<option>Select scanner</option>
    		@foreach ($ct_scanners as $ct)
    		<option value="{{ $ct->id }}">{{ $ct->description }}</option>
    		@endforeach
        </select> <span class="text-danger">*</span></p>
        <table class="table">
            <thead>
                <th>Date</th>
                <th>Scan mode</th>
                <th>Water HU</th>
                <th>Water SD</th>
                <th>Artifacts?</th>
                <th>Initials</th>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">
                        <input class="form-control" type="date" id="qcdate" name="qcdate" size="10" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="scan_type[]" value="Axial" readonly tabindex="-1">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="water_hu[]" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="water_sd[]" required>
                    </td>
                    <td>
                        <select class="form-control" name="artifacts[]" >
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </td>
                    <td rowspan="2">
                        <input type="text" class="form-control" name="initials" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="scan_type[]" value="Helical" readonly tabindex="-1">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="water_hu[]" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="water_sd[]" required>
                    </td>
                    <td>
                        <select class="form-control" name="artifacts[]" >
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
		<p><label for="notes">Notes:</label><br /> <textarea class="form-control" id="notes" name="notes" rows="3" cols="70" placeholder="Enter any notes about the test"></textarea></p>

		<p><button class="form-control" type="SUBMIT">Add QC record</button></p>
	</div>
</form>
<p><span class="text-danger">*</span> Required field</p>

@endsection
