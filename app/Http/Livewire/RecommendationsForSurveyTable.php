<?php

namespace App\Http\Livewire;

use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class RecommendationsForSurveyTable extends DataTableComponent
{
    public function config(): void
    {
        $this->setPrimaryKey('surveyId');
        $this->setDefaultSort('id', 'asc');
        $this->setSingleSortingDisabled();
        $this->setPaginationDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('Resolved'),
            Column::make('Recommendation'),
            Column::make('Date Added', 'rec_add_ts'),
            Column::make('Date Resolved', 'rec_resolve_date'),
            Column::make('Work Order', 'wo_number'),
        ];
    }

    public function query(): Builder
    {
        return Recommendation::query()
            ->where('survey_id', $this->surveyId);
    }

    public function rowView(): string
    {
        return 'livewire-tables.recommendations-for-survey-row';
    }
}
