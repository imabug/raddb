<?php

namespace App\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class SurveyListTable extends DataTableComponent
{
    public int $machine;

    public function mount($machine): void
    {
        $this->machine = $machine;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('test_date', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setColumnSelectDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ])
            ->setSearchDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id'),
            DateColumn::make('Test date', 'test_date')->outputFormat('Y-m-d'),
            Column::make('Test type', 'type.test_type'),
            Column::make('Accession', 'accession'),
            Column::make('Notes', 'notes'),
            Column::make('Survey Report')
                ->label(
                    fn ($row, Column $column) => view('livewire-tables.survey-report-view')
                        ->withRow($row)
                ),
        ];
    }

    public function builder(): Builder
    {
        return TestDate::query()
            ->with(['machine', 'type'])
            ->where('machine_id', $this->machine);
    }
}
