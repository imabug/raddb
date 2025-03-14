<?php

namespace App\Livewire;

use App\Models\Machine;
use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class CalibrationDatesTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setSearchDisabled()
            ->setColumnSelectDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Manufacturer', 'manufacturer.manufacturer'),
            Column::make('Model', 'model'),
            Column::make('Serial Number', 'serial_number'),
            Column::make('Description', 'description')
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.route('machines.show', $row->id).'">'.$row->description.'</a>'
                )
                ->html(),
            DateColumn::make('Last calibration')
                ->label(
                    fn ($row, Column $column) => TestDate::where('machine_id', $row->id)
                        ->latest()
                        ->first()
                        ->test_date ?? ''
                )->outputFormat('Y-m-d'),
            Column::make('Age')
                ->label(
                    fn ($row, Column $column) => Machine::find($row->id)->age
                ),
            Column::make('Room', 'room'),
        ];
    }

    public function builder(): Builder
    {
        return Machine::query()
            ->with('manufacturer')
            ->active()
            ->testEquipment();
    }
}
