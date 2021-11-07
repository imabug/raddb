<x-livewire-tables::table.cell>
  {{ $row->id }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->test_date }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->type->test_type }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->accession }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->notes }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <x-survey-report-link :surveyID="$row->id" />
</x-livewire-tables::table.cell>
