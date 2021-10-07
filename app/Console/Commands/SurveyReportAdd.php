<?php

namespace RadDB\Console\Commands;

use RadDB\Models\TestDate;
use Illuminate\Console\Command;

class SurveyReportAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surveyreport:add {survey_id} {report_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a survey report to the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $surveyId = $this->argument('survey_id');
        $reportFile = $this->argument('report_file');

        $survey = TestDate::findOrFail($surveyId);

        $survey->addMedia($reportFile)
            ->preservingOriginal()
            ->toMediaCollection('survey_report', 'SurveyReports');
    }
}
