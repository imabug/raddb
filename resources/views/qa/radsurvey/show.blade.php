<!-- resources/views/qa/radsurvey/show.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Radiation survey data for {{ $radSurveyData->machine->description }} ({{ $radSurveyData->survey->test_date }} - Survey ID {{ $radSurveyData->survey->id }})</h2>
<table class="table">
<thead>
    <tr>
        <th>SID Accuracy (%)</th>
        <th>Light field Illumination (lux)</th>
        <th>Beam Alignment (&deg;)</th>
        <th>Radiation/Receptor Centering Table (cm)</th>
        <th>Radiation/Receptor Centering Wall (cm)</th>
        <th>LFS Resolution (lp/mm)</th>
        <th>SFS Resolution (lp/mm)</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>{{ $radSurveyData->sid_accuracy_error*100 }}</td>
        <td>{{ $radSurveyData->avg_illumination }}</td>
        <td>{{ $radSurveyData->beam_alignment_error }}</td>
        <td>{{ $radSurveyData->rad_film_center_table }}</td>
        <td>{{ $radSurveyData->rad_film_center_wall }}</td>
        <td>{{ $radSurveyData->lfs_resolution }}</td>
        <td>{{ $radSurveyData->sfs_resolution }}</td>
    </tr>
</tbody>
</table>
@endsection
