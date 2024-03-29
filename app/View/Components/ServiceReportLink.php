<?php

namespace App\View\Components;

use App\Models\TestDate;
use Illuminate\View\Component;
use Illuminate\View\View;

class ServiceReportLink extends Component
{
    /**
     * Survey ID.
     *
     * @int $surveyId
     */
    public ?int $surveyId;

    /**
     * Service report link.
     *
     * @string $surveyLink
     */
    public ?string $serviceReportLink;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?int $surveyId)
    {
        $this->surveyId = $surveyId;

        $survey = TestDate::find($this->surveyId);

        if (!is_null($survey) && $survey->hasMedia('service_report')) {
            $this->serviceReportLink = $survey->getFirstMediaUrl('service_report');
        } else {
            $this->serviceReportLink = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.service-report-link');
    }
}
