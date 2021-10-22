<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Livewire datatables component that provides a list of
 * machines for the machines listing view (/machines/).
 */
class MachineListTable extends DataTableComponent
{
    public string $defaultSortColumn = 'id';
    public string $defaultSortDirection = 'asc';
    public bool $singleColumnSorting = false;
    public bool $paginationEnabled = false;

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Modality', 'modality.modality')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Modality::select('modality')->whereColumn('id', 'modality_id'), $direction);
                }),
            Column::make('Manufacturer', 'manufacturer.manufacturer')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Manufacturer::select('manufacturer')->whereColumn('id', 'manufacturer_id'), $direction);
                }),
            Column::make('Model', 'model')
                ->sortable(),
            Column::make('SN', 'serial_number'),
            Column::make('Description', 'description')
                ->searchable(),
            Column::make('Location', 'location.location')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Location::select('location')->whereColumn('id', 'location_id'), $direction);
                }),
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
