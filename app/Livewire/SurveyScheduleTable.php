<?php

namespace App\Livewire;

use App\Models\SurveyScheduleView;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class SurveyScheduleTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setSortingEnabled()
            ->setDefaultSort('prevSurveyDate', 'asc')
            ->setPaginationDisabled()
            ->setSearchEnabled()
            ->setSearchVisibilityEnabled()
            ->setColumnSelectDisabled()
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
            DateColumn::make('Previous', 'prevSurveyDate')
                ->outputFormat('Y-m-d')
                ->sortable(),
            Column::make('Prev Survey ID', 'prevSurveyID')
                ->view('livewire-tables.survey-id-view'),
            DateColumn::make('Current', 'currSurveyDate')
                ->outputFormat('Y-m-d')
                ->sortable(),
            Column::make('Current Survey ID', 'currSurveyID')
                ->view('livewire-tables.survey-id-view'),
        ];
    }

    public function builder(): Builder
    {
        return SurveyScheduleView::query()
            ->with('machine', 'prevSurvey', 'currSurvey')
            ->orderBy('prevSurveyDate', 'asc')
            ->orderBy('id', 'asc');
    }
}
