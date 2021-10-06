<div>
    <table>
    <thead>
    <th>ID</th>
    <th>Description</th>
    <th>Model</th>
    <th>Serial Number</th>
    </thead>
    <tbody>
    @foreach($machines as $m)
        <tr>
        <td>{{$m->id}}</td>
        <td>{{$m->description}}</td>
        <td>{{$m->model}}</td>
        <td>{{$m->serial_number}}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
