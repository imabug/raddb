<!-- resources/views/machine/surveys.blade.php -->

<h3><span class="label label-default">Survey Information</span></h3>

<livewire:survey-list-table :machine="$machine->id" />

@if (Auth::check())
  <p>
    <a href="{{ route('surveys.createSurveyFor',  $machine->id)}}">
      <x-glyphs.plus />Add survey
    </a>
  </p>
@endif
