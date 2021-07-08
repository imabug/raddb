<!-- resources/views/machine/recs.blade.php -->

<h3><span class="label label-default">Survey Recommendations</span></h3>
<table class="table">
    <thead>
        <tr>
     <th scope="col">Survey ID</th>
     <th scope="col">Recommendation</th>
     <th scope="col">Resolved</th>
     <th scope="col">Service Report</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recommendations as $rec)
        <tr>
            <th scope="row"><a href="{{ route('recommendations.show', $rec->survey_id) }}">{{ $rec->survey_id }}</a></th>
            <td>{{ $rec->recommendation }}</td>
            <td>
@if($rec->resolved)
    <span class="glyphicon glyphicon-ok" aria-hidden-"true"></span>
@endif
            </td>
            @if (Storage::disk('local')->exists($rec->service_report_path))
            <td><a href="{{ Storage::disk('local')->url($rec->service_report_path) }}" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
            @else
            <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
