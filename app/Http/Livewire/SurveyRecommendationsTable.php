<?php

namespace App\Http\Livewire;

use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SurveyRecommendationsTable extends DataTableComponent
{
    public $machine;

    public function mount($machine)
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
            Column::make('Resolved', 'resolved'),
            // Need to figure out how to integrate with spatie/laravel-medialibrary to
            // get the service report link
            //Column::make('Service Report'),
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
