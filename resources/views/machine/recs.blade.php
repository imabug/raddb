<h3><span class="label label-default">Survey Recommendations</span></h3>
<table class="table">
    <thead>
        <tr>
            <th>Survey ID</th>
            <th>Recommendation</th>
            <th>Resolved</th>
            <th>Service Report</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recommendations as $rec)
        <tr>
            <td><a href="{{ route('recommendations.show', $rec->survey_id) }}">{{ $rec->survey_id }}</a></td>
            <td>{{ $rec->recommendation }}</td>
            <td>
@if($rec->resolved)
    <span class="glyphicon glyphicon-ok" aria-hidden-"true"></span>
@endif
            </td>
            @if (empty($rec->service_report_path) || is_null($rec->service_report_path))
            <td></td>
            @else
            <td><a href="{{ route('servicereports.show', ["service", $rec->id]) }}" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
