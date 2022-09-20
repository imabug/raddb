<?php

namespace App\Http\Livewire;

use App\Models\SurveyScheduleView;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SurveyScheduleTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('prevSurveyDate', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setEagerLoadAllRelationsEnabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.route('machines.show', $row->id).'">'.$row->description.'</a>'
                )
                ->html(),
            Column::make('Previous', 'prevSurveyDate')
                ->sortable(),
            Column::make('Prev Survey ID', 'prevSurveyID')
                ->view('livewire-tables.survey-id-view'),
            Column::make('Current', 'currSurveyDate')
                ->sortable(),
            Column::make('Current Survey ID', 'currSurveyID')
                ->view('livewire-tables.survey-id-view'),
        ];
    }

    // public function rowView(): string
    // {
    //     // Use a custom row view so that things like the manufacturer,
    //     // modality, description, location can be made clickable URLs
    //     return 'livewire-tables.survey-schedule-row';
    // }

    public function builder(): Builder
    {
        return SurveyScheduleView::query()
            ->with('machine', 'prevSurvey', 'currSurvey');
    }
}
