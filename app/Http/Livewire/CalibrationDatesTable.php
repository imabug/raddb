<?php

namespace App\Http\Livewire;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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
            //Column::make('Age', 'age'),
            Column::make('Room', 'room'),
            //Column::make('Last calibration', 'testdate.test_date'),
        ];
    }

    public function builder(): Builder
    {
        return Machine::query()
            ->with(['manufacturer', 'testdate'])
            ->testEquipment();
    }

    // public function rowView(): string
    // {
    //     return 'livewire-tables.calibration-dates-row';
    // }
}
