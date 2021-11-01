<?php

namespace App\View\Components;

use App\Models\TestDate;
use Illuminate\View\Component;

class SurveyReportLink extends Component
{
    /**
     * Survey ID
     *
     * @int $surveyID
     */
    public $surveyID;

    /**
     * Survey report link
     *
     * @string $surveyLink
     */
    public $surveyLink;

    /**
     * Create a new component instance.
     *
     *
     * @param int $surveyID
     * @return void
     */
    public function __construct(?int $surveyID)
    {
        $this->surveyID = $surveyID;

        $survey = TestDate::find($this->surveyID);

        if (!is_null($survey) && $survey->hasMedia('survey_report')) {
            $this->surveyLink = $survey->getFirstMediaUrl('survey_report');
        } else {
            $this->surveyLink = "No media";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.survey-report-link');
    }
}
