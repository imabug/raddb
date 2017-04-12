<!-- resources/views/gendata/radOutput.blade.php -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>kV</th>
                <th>Output (mGy/mAs)</th>
            </tr>
        </thead>
        <tbody>
@foreach ($radOutput as $r)
            <tr>
                <td>{{ $r->kv }}</td>
                <td>{{ $r->output }}</td>
            </tr>
@endforeach
        </tbody>
    </table>
    <div class="panel panel-default">
        <div class="panel-body">
            <p>{!! $radOutputChart->render() !!}</p>
        </div>
    </div>