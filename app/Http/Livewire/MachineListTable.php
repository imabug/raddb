<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

/**
 * Livewire datatables component that provides a list of
 * machines for the machines listing view (/machines/).
 */
class MachineListTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setSearchDisabled()
            ->setColumnSelectDisabled()
            ->setFiltersVisibilityEnabled()
            ->setFilterLayoutSlideDown()
            ->setEagerLoadAllRelationsEnabled()
            ->setFilterLayoutPopover()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

    // Default filters.
    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    'Active'   => 'Active',
                    'Removed'  => 'Removed',
                    'Inactive' => 'Inactive',
                    ''         => 'All',
                ]),
            MultiSelectFilter::make('Modality')
                ->options(
                    Modality::query()
                        ->orderBy('modality')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($modality) => $modality->modality)
                        ->toArray()
                ),
            MultiSelectFilter::make('Manufacturer')
                ->options(
                    Manufacturer::query()
                        ->orderBy('manufacturer')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($manufacturer) => $manufacturer->manufacturer)
                        ->toArray()
                ),
            MultiSelectFilter::make('Location')
                ->options(
                    Location::query()
                        ->orderBy('location')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($location) => $location->location)
                        ->toArray()
                ),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Modality', 'modality.modality')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Modality::select('modality')->whereColumn('id', 'modality_id'), $direction);
                })
                ->format(
                    fn ($value, $row, Column $column) => '<a href="/machines?[filters][status]=Active&[filters][modality]='.$row->modality->modality.'">'.$row->modality->modality.'</a>'
                ),
            Column::make('Manufacturer', 'manufacturer.manufacturer')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Manufacturer::select('manufacturer')->whereColumn('id', 'manufacturer_id'), $direction);
                })
                ->format(
                    fn ($value, $row, Column $column) => '<a href="/machines?[filters][status]=Active&[filters][manufacturer]='.$row->manufacturer->manufacturer.'">'.$row->manufacturer->manufacturer.'</a>'
                ),
            Column::make('Model', 'model')
                ->sortable(),
            Column::make('SN', 'serial_number'),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.route('machines.show', $row->id).'">'.$row->description.'</a>'
                ),
            Column::make('Location', 'location.location')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Location::select('location')->whereColumn('id', 'location_id'), $direction);
                })
                ->format(
                    fn ($value, $row, Column $column) => '<a href="/machines?[filters][status]=Active&[filters][location]='.$row->location->location.'">'.$row->location->location.'</a>'
                ),
            Column::make('Age', 'age')
                ->format(
                    fn ($value, $row, Column $column) => $row->age
                ),
            Column::make('Room', 'room'),
        ];
    }

    public function builder(): Builder
    {
        return Machine::query()
            ->with(['modality', 'manufacturer', 'location'])
            ->when(
                $this->getAppliedFilterWithValue('status'),
                fn ($query, $status) => $query->where('machine_status', $status)
            )
            ->when(
                $this->getAppliedFilterWithValue('modality'),
                fn ($query, $modality) => $query
                    ->where(Modality::select('modality')
                        ->whereColumn('id', 'modality_id'), $modality)
            )
            ->when(
                $this->getAppliedFilterWithValue('manufacturer'),
                fn ($query, $manufacturer) => $query
                    ->where(Manufacturer::select('manufacturer')
                        ->whereColumn('id', 'manufacturer_id'), $manufacturer)
            )
            ->when(
                $this->getAppliedFilterWithValue('location'),
                fn ($query, $location) => $query
                    ->where(Location::select('location')
                        ->whereColumn('id', 'location_id'), $location)
            );
    }

    // public function rowView(): string
    // {
    //     // Use a custom row view so that things like the manufacturer,
    //     // modality, description, location can be made clickable URLs
    //     return 'livewire-tables.machines-list-row';
    // }
}
