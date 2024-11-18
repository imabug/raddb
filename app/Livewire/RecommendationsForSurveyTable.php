<?php

namespace App\Livewire;

use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class RecommendationsForSurveyTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setSearchDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ])
            ->setColumnSelectDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('Resolved'),
            Column::make('Recommendation'),
            DateColumn::make('Date Added', 'rec_add_ts'),
            DateColumn::make('Date Resolved', 'rec_resolve_date'),
            Column::make('Work Order', 'wo_number'),
        ];
    }

    public function builder(): Builder
    {
        return Recommendation::query()
            ->where('survey_id', $this->surveyId);
    }
}
