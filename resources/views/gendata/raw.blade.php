<!-- resources/views/gendata/raw.blade.php -->

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Set kV</th>
            <th>Set mA</th>
            <th>Set time</th>
            <th>Set mAs</th>
            <th>kV<sub>avg</sub></th>
            <th>kV<sub>max</sub></th>
            <th>kV<sub>eff</sub></th>
            <th>Exp time (s)</th>
            <th>Exposure (mGy)</th>
        </tr>
    </thead>
    <tbody>
@foreach ($gendata as $gd)
        <tr>
            <td>{{ $gd->kv_set }}</td>
            <td>{{ $gd->ma_set }}</td>
            <td>{{ $gd->time_set }}</td>
            <td>{{ $gd->mas_set }}</td>
            <td>{{ $gd->kv_avg }}</td>
            <td>{{ $gd->kv_max }}</td>
            <td>{{ $gd->kv_eff }}</td>
            <td>{{ $gd->exp_time }}</td>
            <td>{{ $gd->exposure }}</td>
       </tr>
@endforeach
    </tbody>
</table>