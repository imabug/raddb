<?php

namespace App\Http\Livewire;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MachineListTable extends DataTableComponent
{
    public string $defaultSortColumn = 'id';
    public string $defaultSortDirection = 'asc';
    public bool $singleColumnSorting = true;
    public bool $paginationEnabled = false;

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Modality', 'modality.modality')
                ->sortable(),
            Column::make('Manufacturer', 'manufacturer.manufacturer')
                ->sortable(),
            Column::make('Model', 'model')
                ->sortable(),
            Column::make('SN','serial_number'),
            Column::make('Description', 'description')
                ->searchable(),
            Column::make('Location', 'location.location')
                ->sortable(),
            Column::make('Age', 'age'),
            Column::make('Room', 'room'),
        ];
    }

    public function query(): Builder
    {
        return Machine::query()
            ->with(['modality', 'manufacturer', 'location'])
            ->active();
    }

    public function rowView(): string
    {
        // Use a custom row view so that things like the manufacturer,
        // modality, description, location can be made clickable URLs
        return 'livewire-tables.machines-list-row';
    }
}
