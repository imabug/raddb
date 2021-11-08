<?php

namespace App\Http\Livewire;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CalibrationDatesTable extends DataTableComponent
{
    public string $defaultSortColumn = 'id';
    public string $defaultSortDirection = 'asc';
    public bool $singleColumnSorting = false;
    public bool $paginationEnabled = false;
    public bool $showSearch = false;

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Manufacturer', 'manufacturer.manufacturer'),
            Column::make('Model', 'model'),
            Column::make('Serial Number', 'serial_number'),
            Column::make('Description', 'description'),
            Column::make('Age', 'age'),
            Column::make('Room', 'room'),
            Column::make('Last calibration', 'testdate'),
        ];
    }

    public function query(): Builder
    {
        return Machine::with([
            'manufacturer',
            'testdate' => function ($query) {
                $query->where('type_id', '10')->latest('test_date');
            }, ])
            ->active()
            ->testEquipment();
    }

    public function rowView(): string
    {
        return 'livewire-tables.calibration-dates-row';
    }
}