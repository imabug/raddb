<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

/**
 * Livewire datatables component that provides a list of
 * machines for the machines listing view (/machines/).
 */
class MachineListTable extends DataTableComponent
{
    public function mount()
    {
        $this->setFilter('machine_status', 'Active');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setSortingEnabled()
            ->setDefaultSort('id', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setSearchEnabled()
            ->setSearchVisibilityEnabled()
            ->setColumnSelectDisabled()
            ->setFiltersEnabled()
            ->setFilterPillsEnabled()
            ->setFiltersVisibilityEnabled()
            ->setFilterLayoutSlideDown()
            ->setEagerLoadAllRelationsEnabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

    // Default filters.
    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'machine_status')
                ->options([
                    'Active'      => 'Active',
                    'Removed'     => 'Removed',
                    'Inactive'    => 'Inactive',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('machine_status', $value);
                }),
            SelectFilter::make('Modality')
                ->options(
                    Modality::query()
                        ->orderBy('modality')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($modality) => $modality->modality)
                        ->toArray()
                )
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('modality_id', $value);
                }),
            SelectFilter::make('Manufacturer')
                ->options(
                    Manufacturer::query()
                        ->orderBy('manufacturer')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($manufacturer) => $manufacturer->manufacturer)
                        ->toArray()
                )
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('Manufacturer_id', $value);
                }),
            SelectFilter::make('Location')
                ->options(
                    Location::query()
                        ->orderBy('location')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($location) => $location->location)
                        ->toArray()
                )
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('location_id', $value);
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.route('machines.show', $row->id).'">'.$row->description.'</a>'
                )
                ->html(),
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
                ->sortable()
                ->searchable(),
            Column::make('SN', 'serial_number'),
            Column::make('Location', 'location.location')
                ->sortable(function (Builder $query, $direction) {
                    return $query
                        ->orderBy(Location::select('location')->whereColumn('id', 'location_id'), $direction);
                }),
            Column::make('Room', 'room'),
            Column::make('Age')
                ->label(
                    fn ($row, Column $column) => Machine::find($row->id)->age
                ),
            Column::make('Edit')
                ->label(
                    fn ($row, Column $column) => view('livewire-tables.edit-delete')->withRow($row)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Machine::query()
            ->with(['modality', 'manufacturer', 'location']);
    }
}
