<?php

namespace App\Http\Livewire;

use App\Models\TestDate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

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
            // Need to figure out how to integrate this with spatie/laravel-medialibrary
            // to get the survey report link
            LinkColumn::make('Survey report')
                ->title(fn($row) => 'Report')
                ->location(
                    function ($row) {
                        $reports = $row->getMedia();
                        if ($reports->count() > 0) {
                            return $reports->getUrl();
                        }
                    }
                ),
        ];
    }

    public function builder(): Builder
    {
        return TestDate::query()
            ->with('machine', 'type')
            ->where('machine_id', $this->machine);
    }

    // public function rowView(): string
    // {
    //     return 'livewire-tables.survey-list-row';
    // }
}
