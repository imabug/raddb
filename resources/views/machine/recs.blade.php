{{-- resources/views/machine/recs.blade.php --}}
{{-- Used in resources/views/machine/detail.blade.php --}}
<h3><span class="label label-default">Survey Recommendations</span></h3>
{{-- Use App\Livewire\SurveyRecommendationsTable --}}
<livewire:survey-recommendations-table :machine="$machine->id" />

