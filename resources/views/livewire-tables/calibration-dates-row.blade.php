<x-livewire-tables::table.cell>
  {{ $row->id }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->manufacturer->manufacturer }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->model }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->serial_number }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <a href="{{ route('machines.show', $row->id) }}">{{ $row->description }}</a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->age }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  {{ $row->room }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  @foreach ($row->testdate as $td)
    @if($loop->first)
      {{ $td->test_date }}
    @endif
  @endforeach
</x-livewire-tables::table.cell>
