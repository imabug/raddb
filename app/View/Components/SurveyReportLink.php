<?php

namespace App\View\Components;

use App\Models\TestDate;
use Illuminate\View\Component;
use Illuminate\View\View;

class SurveyReportLink extends Component
{
    /**
     * Survey ID.
     *
     * @int $surveyID
     */
    public ?int $surveyID;

    /**
     * Survey report link.
     *
     * @string $surveyLink
     */
    public ?string $surveyLink;

    /**
     * Create a new component instance.
     *
     *
     * @param int $surveyID
     *
     * @return void
     */
    public function __construct(?int $surveyID)
    {
        $this->surveyID = $surveyID;

        $survey = TestDate::find($this->surveyID);

        if (!is_null($survey) && $survey->hasMedia('survey_reports')) {
            $this->surveyLink = $survey->getFirstMediaUrl('survey_reports');
        } else {
            $this->surveyLink = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.survey-report-link');
    }
}
