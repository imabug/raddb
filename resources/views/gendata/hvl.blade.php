<!-- resources/views/gendata/hvl.blade.php -->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>kV</th>
            <th>HVL</th>
        </tr>
    </thead>
    <tbody>
@foreach ($hvl as $h)
        <tr>
            <td>{{ $h->kv }}</td>
            <td>{{ $h->hvl }}</td>
        </tr>
@endforeach
    </tbody>
</table>
{!! Charts::assets(['google']) !!}
<div class="panel panel-default">
    <div class="panel-body">
        <p>{!! $hvlChart->render() !!}</p>
    </div>
</div>
