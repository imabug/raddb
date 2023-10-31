<?php

namespace App\Livewire;

use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SurveyRecommendationsTable extends DataTableComponent
{
    public int $machine;

    public function mount($machine): void
    {
        $this->machine = $machine;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'asc')
            ->setSingleSortingDisabled()
            ->setPaginationDisabled()
            ->setColumnSelectDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Survey ID', 'id'),
            Column::make('Recommendation', 'recommendation')
                ->searchable(),
            Column::make('Resolved', 'resolved')
                ->view('components.checkmark-view'),
            Column::make('Service Report', 'id')
                ->view('livewire-tables.service-report-view'),
        ];
    }

    public function builder(): Builder
    {
        return Recommendation::query()
            ->whereHas(
                'survey',
                function ($query) {
                    $query->where('machine_id', $this->machine);
                }
            );
    }
}
