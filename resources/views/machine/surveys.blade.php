<h3><span class="label label-default">Survey Information</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Survey ID</th>
            <th>Test Date</th>
            <th>Test Type</th>
            <th>Accession</th>
            <th>Notes</th>
            <th>Survey Report</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($surveys as $survey)
        <tr>
            <td><a href="{{ route('recommendations.show', $survey->id) }}">{{ $survey->id }}</a></td>
            <td>{{ $survey->test_date }}</td>
            <td>{{ $survey->type->test_type }}</td>
            <td>{{ $survey->accession }}</td>
            <td>{{ $survey->notes }}</td>
            @if (Storage::exists($survey->report_file_path))
            <td><a href="{{ Storage::url($survey->report_file_path) }} " target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
            @else
            <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
@if (Auth::check())
<p><a href="{{ route('surveys.createSurveyFor',  $machine->id)}}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add survey</a></p>
@endif
