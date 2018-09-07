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
            <td><a href="{{ route('recommendations.show', $survey->id) }}">{{ $survey->id }}</a></td>
            <td>{{ $survey->test_date }}</td>
            <td>{{ $survey->type->test_type }}</td>
            <td>{{ $survey->accession }}</td>
            <td>{{ $survey->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (Auth::check())
<p><a href="{{ route('surveys.createSurveyFor',  $machine->id)}}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add survey</a></p>
@endif
