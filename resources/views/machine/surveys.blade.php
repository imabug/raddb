<!-- resources/views/machine/surveys.blade.php -->

<h3><span class="label label-default">Survey Information</span></h3>
<table class="table">
    <thead>
        <tr>
     <th scope="col">Survey ID</th>
     <th scope="col">Test Date</th>
     <th scope="col">Test Type</th>
     <th scope="col">Accession</th>
     <th scope="col">Notes</th>
     <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($surveys as $survey)
        <tr>
            <th scope="row"><a href="{{ route('recommendations.show', $survey->id) }}">{{ $survey->id }}</a></th>
            <td>{{ $survey->test_date }}</td>
            <td>{{ $survey->type->test_type }}</td>
            <td>{{ $survey->accession }}</td>
            <td>{{ $survey->notes }}</td>
            <td>
        @if($survey->hasMedia('survey_report'))
                <a href="{{ $survey->getFirstMediaUrl('survey_report') }}" target="_blank" title="Survey report" alt="Survey report">
                      <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </a>
        @endif
             </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (Auth::check())
<p><a href="{{ route('surveys.createSurveyFor',  $machine->id)}}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add survey</a></p>
@endif
