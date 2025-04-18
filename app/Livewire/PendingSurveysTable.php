<?php

namespace App\Livewire;

use App\Models\Machine;
use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

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
            Column::make('Description', 'machine.description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.
                        route('machines.show', TestDate::find($row->id)->machine_id).
                        '">'.
                        Machine::find(TestDate::find($row->id)->machine_id)->description.
                        '</a>'
                )
                ->html(),
            DateColumn::make('Date scheduled', 'test_date')
                ->outputFormat('Y-m-d')
                ->sortable(),
            Column::make('Test Type', 'type.test_type'),
            Column::make('Accession'),
            Column::make('Survey Note', 'notes'),
            Column::make('Edit')
                ->label(
                    fn ($row, Column $column) => view('livewire-tables.edit-survey')->withRow($row)
                ),
            Column::make('Cancel')
                ->label(
                    fn ($row, Column $column) => view('livewire-tables.cancel-survey')->withRow($row)
                ),
        ];
    }

    public function builder(): Builder
    {
        return TestDate::query()
            ->with('machine', 'type')
            ->pending();
    }
}
