<!-- resources/views/ar/cexp.blade.php -->

    @extends('layouts.app')

    @section('content')
    <h2>Mammography Continued Experience List</h2>

    <h3>Mammography units</h3>
    <table class="table table-striped table-hover table-sm">
     <thead>
     <th scope="col">ID</th>
     <th scope="col">Description</th>
     <th scope="col">Facility</th>
     <th scope="col">Survey date</th>
     <th scope="col">Survey date</th>
     </thead>
     <tbody>
     @foreach ($mammDates as $desc => $m)
     <tr>
     <td>{{$desc}}</td>
     <td>{{$m->location->location}}</td>
     <td>{{$m->date1}}</td>
     <td>{{$m->date2}}</td>
     </tr>
     @endforeach
     </tbody>
    </table>

    <h3>Stereotactic Breast Biopsy units</h3>
    <table class="table table-striped table-hover table-sm">
     <thead>
     <th scope="col">ID</th>
     <th scope="col">Description</th>
     <th scope="col">Facility</th>
     <th scope="col">Survey date</th>
     <th scope="col">Survey date</th>
     </thead>
     <tbody>
     @foreach ($sbbMachines as $sbb)
     <tr>
     <th scope="row">{{ $sbb->id }}</th>
     <td>{{$sbb->description}}</td>
     <td>{{$sbb->location->location}}</td>
     <td>{{$sbb->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->shift()->test_date}}</td>
     <td>{{$sbb->testdate->whereIn('type_id', [1, 2])->sortByDesc('test_date')->shift(2)->pop()->test_date}}</td>
     </tr>
     @endforeach
     </tbody>
    </table>
    @endsection
