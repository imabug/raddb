{{-- resources/views/ar/cexp.blade.php --}}
{{-- This blade template is used by the mammContExp method in AnnReportController --}}

    @extends('layouts.app')

    @section('content')
    <h2>Mammography Continued Experience List</h2>

    <h3>Mammography units</h3>
    <table class="table table-striped table-hover table-sm">
     <thead>
     <th scope="col">Description</th>
     <th scope="col">Facility</th>
     <th scope="col">Survey date</th>
     <th scope="col">Survey date</th>
     </thead>
     <tbody>
     @foreach ($mammDates as $desc => $m)
     <tr>
     <td>{{$desc}}</td>
     <td>{{$m['location']}}</td>
     <td>{{$m['date1']}}</td>
     <td>{{$m['date2']}}</td>
     </tr>
     @endforeach
     </tbody>
    </table>

    <h3>Stereotactic Breast Biopsy units</h3>
    <table class="table table-striped table-hover table-sm">
     <thead>
     <th scope="col">Description</th>
     <th scope="col">Facility</th>
     <th scope="col">Survey date</th>
     <th scope="col">Survey date</th>
     </thead>
     <tbody>
     @foreach ($sbbDates as $desc => $m)
     <tr>
       <td>{{$desc}}</td>
       <td>{{$m['location']}}</td>
       <td>{{$m['date1']}}</td>
       <td>{{$m['date2']}}</td>
     </tr>
     @endforeach
     </tbody>
    </table>
    @endsection
