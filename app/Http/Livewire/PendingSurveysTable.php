<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PendingSurveysTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('test_date', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setColumnSelectDisabled()
            ->setSearchDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

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
            Column::make('Survey Note', 'notes'),
        ];
    }

    public function builder(): Builder
    {
        return TestDate::query()
            ->with('machine', 'type')
            ->pending();
    }
}
