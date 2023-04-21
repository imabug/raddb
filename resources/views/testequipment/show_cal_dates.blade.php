{{-- resources/views/testequipment/show_cal_dates.blade.php --}}
{{-- Used by the showCalDates() method in TestEquipmentController --}}
@extends('layouts.app')

@section('content')
  <h2>Recent Test Equipment Calibration Dates</h2>
  <div>
    <livewire:calibration-dates-table />
  </div>
@endsection
