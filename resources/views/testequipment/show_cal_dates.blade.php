<!-- resources/views/testequipment/show_cal_dates.blade.php -->

@extends('layouts.app')

@section('content')
  <h2>Recent Test Equipment Calibration Dates</h2>
  <div>
    <livewire:calibration-dates-table />
  </div>
@endsection
