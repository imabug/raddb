<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SurveyListTable extends DataTableComponent
{
    public string $defaultSortColumn = 'id';
    public string $defaultSortDirection = 'asc';
    public bool $singleColumnSorting = false;
    public bool $paginationEnabled = false;
    public bool $showSearch = false;

    public $machine;

    public function mount($machine)
    {
        $this->machine = $machine;
    }

    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id'),
            Column::make('Test date', 'test_date'),
            Column::make('Test type', 'type.test_type'),
            Column::make('Accession', 'accession'),
            Column::make('Notes', 'notes'),
            Column::make('Survey report'),
        ];
    }

    public function query(): Builder
    {
        return TestDate::query()
            ->with('machine','type')
            ->where('machine_id', $this->machine);
    }

    public function rowView(): string
    {
        return 'livewire-tables.survey-list-row';
    }
}
