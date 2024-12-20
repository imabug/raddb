{{-- resources/views/ar/annrep.blade.php --}}
{{-- Template is used by the annrep method of AnnReportController --}}

    @extends('layouts.app')

    @section('content')
    <h2>Medical Physics Annual Report Data for {{$year}}</h2>

    <h3>Survey Type Breakdown ({{$surveyTotal}} surveys)</h3>
    <table class="table table-striped table-hover table-sm">
      <thead>
        <th scope="col">Test Type</th>
        <th scope="col">Number</th>
      </thead>
      <tbody>
        @foreach($surveyTypeCount as $type => $count)
          <tr>
            <td>{{$type}}</td>
            <td>{{$count}} ({{round(($count/$surveyTotal*100), 1)}}%)</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <h3>Imaging Equipment Inventory ({{$modalitiesCount->count()}} modalities)</h3>
    <table class="table table-striped table-hover table-sm">
      <thead>
        <th scope="col">Modality</th>
        <th scope="col">Number</th>
      </thead>
      <tbody>
     @foreach($modalitiesCount as $modality => $count)
       <tr>
         <td>{{$modality}}</td>
         <td>{{$count}} ({{round(($count/$machineTotal*100), 1)}}%)</td>
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
        <tr>
          <td>{{$location}}</td>
          <td>{{$count}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <h3>New installations ({{$newInstalls->count()}})</h3>
    <table class="table table-striped table-hover table-sm">
        <thead>
            <th scope="col">Machine</th>
            <th scope="col">Modality</th>
            <th scope="col">Location</th>
            <th scope="col">Install date</th>
        </thead>
        <tbody>
            @foreach($newInstalls as $m)
                <tr>
                  <td>{{$m->description}}</td>
                  <td>{{$m->modality->modality}}</td>
                  <td>{{$m->location->location}}</td>
                  <td>{{$m->install_date}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Removed machines ({{$removed->count()}})</h3>
    <table class="table table-striped table-hover table-sm">
        <thead>
            <th scope="col">Machine</th>
            <th scope="col">Modality</th>
            <th scope="col">Location</th>
            <th scope="col">Remove date</th>
        </thead>
        <tbody>
            @foreach($removed as $m)
              <tr>
                <td>{{$m->description}}</td>
                <td>{{$m->modality->modality}}</td>
                <td>{{$m->location->location}}</td>
                <td>{{$m->deleted_at}}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
