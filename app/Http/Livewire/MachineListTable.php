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
                ->sortable()
                ->searchable(),
            Column::make('Manufacturer', 'manufacturer.manufacturer')
                ->sortable()
                ->searchable(),
            Column::make('Model', 'model')
                ->sortable()
                ->searchable(),
            Column::make('SN', 'serial_number'),
            Column::make('Description', 'description'),
            Column::make('Location', 'location.location')
                ->sortable()
                ->searchable(),
            Column::make('Age', 'age'),
            Column::make('Room', 'room'),
        ];
    }

    public function query(): Builder
    {
        return Machine::with('modality', 'manufacturer', 'location')
            ->active();
    }
}
