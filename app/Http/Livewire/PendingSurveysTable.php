<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PendingSurveysTable extends DataTableComponent
{
    public string $defaultSortColumn = 'test_date';
    public string $defaultSortDirection = 'asc';
    public bool $singleColumnSorting = false;
    public bool $paginationEnabled = false;
    public bool $showSearch = false;

    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id')
                ->sortable(),
            Column::make('Description', 'machine.description'),
            Column::make('Date scheduled', 'test_date')
                ->sortable(),
            Column::make('Test Type', 'type.test_type'),
            Column::make('Accession'),
            Column::make('Survey Note'),
        ];
    }

    public function rowView(): string
    {
        return 'livewire-tables.pending-surveys-row';
    }

    public function query(): Builder
    {
        return TestDate::with('machine', 'type')
            ->pending();
    }
}
