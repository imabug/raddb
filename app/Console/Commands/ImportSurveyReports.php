<?php

namespace App\Console\Commands;

use App\Models\TestDate;
use Illuminate\Console\Command;

class ImportSurveyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:survey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import survey reports into the DB using spatie/medialibrary';

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
        $file = '';

        $surveys = TestDate::whereNotNull('report_file_path')->get();

        foreach ($surveys as $s) {
            // See if the report_file_path starts with 'public/SurveyReports'
            if (substr($s->report_file_path, 0, 20) == 'public/SurveyReports') {
                $file = '/opt/www/raddb/public/storage/oldSurveyReports/'.substr($s->report_file_path, 21);
            }
            if (substr($s->report_file_path, 0, 13) == 'SurveyReports') {
                $file = '/opt/www/raddb/public/storage/oldSurveyreports/'.substr($s->report_file_path, 14);
            }
            if (substr($s->report_file_path, 0, 4) == '2018') {
                $file = '/opt/www/raddb/public/storage/oldSurveyReports/'.$s->report_file_path;
            }
            if (file_exists($file)) {
                $s->addMedia($file)
                    ->preservingOriginal()
                    ->toMediaCollection('survey_report', 'SurveyReports');
                $this->info($file.'added to medialibrary');
            }
        }
    }
}
