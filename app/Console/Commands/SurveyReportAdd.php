<?php

namespace RadDB\Console\Commands;

use RadDB\TestDate;
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
        $survey_id = $this->argument('survey_id');
        $report_file = $this->argument('report_file');

        $survey = TestDate::findOrFail($survey_id);

        $survey->addMediaFromFile('report_file')
            ->toMediaCollection('survey_report', 'SurveyReports');
    }
}
