<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PendingSurveysTable extends DataTableComponent
{
    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id'),
            Column::make('Description', 'machine.description'),
            Column::make('Date scheduled', 'test_date'),
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
            ->pending()
            ->orderBy('testdates.test_date', 'asc');
    }
}
