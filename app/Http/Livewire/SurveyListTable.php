<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SurveyListTable extends DataTableComponent
{
    public $machine;

    public function mount($machine)
    {
        $this->machine = $machine;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('test_date', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ])
            ->setSearchDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id'),
            Column::make('Test date', 'test_date'),
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

    // public function rowView(): string
    // {
    //     return 'livewire-tables.survey-list-row';
    // }
}
