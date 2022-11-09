<!-- resources/views/ar/annrep.blade.php -->

    @extends('layouts.app')

    @section('content')
    <h2>Medical Physics Annual Report Data for {{$year}}</h2>

    <h3>Survey Type Breakdown</h3>
    <table class="table table-striped table-hover table-sm">
    <thead>
    <th scope="col">Test Type</th>
    <th scope="col">Number</th>
    </thead>
    <tbody>
     @foreach($surveyTypeCount as $type => $count)
        <tr>
            <td>{{$type}}</td>
            <td>{{$count}} ({{round(($count/$surveyTypeCount['Total surveys']*100), 1)}}%)</td>
        </tr>
    @endforeach
    </tbody>
    </table>

    <h3>Imaging Equipment Inventory ({{$modalitiesCount->count()-1}} modalities)</h3>
    <table class="table table-striped table-hover table-sm">
      <thead>
        <th scope="col">Modality</th>
        <th scope="col">Number</th>
      </thead>
      <tbody>
     @foreach($modalitiesCount as $modality => $count)
       <tr>
         <td>{{$modality}}</td>
         <td>{{$count}} ({{round(($count/$modalitiesCount['Total machines']*100), 1)}}%)</td>
       </tr>
     @endforeach
      </tbody>
    </table>

             <h3>Locations ({{$locationsCount->count()}} locations)</h3>
     <table class="table table-striped table-hover table-sm">
       <thead>
         <th scope="col">Modality</th>
         <th scope="col">Number</th>
       </thead>
       <tbody>
       @foreach($locationsCount as $location => $count)
           <td>{{$location}}</td>
           <td>{{$count}}</td>
         </tr>
       @endforeach
       </tbody>
     </table>

    @endsection
