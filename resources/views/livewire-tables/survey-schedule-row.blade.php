<x-livewire-tables::table.cell>
  <a href="{{ route('machines.show', $row->machine->id) }}">{{ $row->id }}</a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <a href="{{ route('machines.show', $row->machine->id) }}">{{ $row->machine->description }}</a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->prevSurveyDate }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->prevSurveyID }}
  <x-survey-report-link :surveyID="$row->prevSurveyID" />
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->currSurveyDate }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->currSurveyID }}
  <x-survey-report-link :surveyID="$row->currSurveyID" />
</x-livewire-tables::table.cell>
