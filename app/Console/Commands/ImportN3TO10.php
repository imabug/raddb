<?php

namespace App\Console\Commands;

use App\Models\GenData;
use App\Models\LeedsN3;
use App\Models\Machine;
use App\Models\TestDate;
use App\Models\Tube;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportN3TO10 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:N3TO10
{file : Excel spreadsheet to load Leeds N3 and TO.10 data from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Leeds N3 and TO.10 low contrast test object data from the specified Excel spreadsheet';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $progressBar = $this->output->createProgressBar();
        $progressBar->start();

        // Load the spreadsheet
        $surveyFile = $this->argument('file');

        $reader = new Xlsx();
        $spreadsheet = new Spreadsheet();

        $spreadsheet = $reader
            ->setReadDataOnly(true)
            ->setLoadSheetsOnly(['Gen_form', 'Sheet1'])
            ->load($surveyFile);

        $progressBar->advance();

        // Get the survey ID (cell F13)
        $surveyId = $spreadsheet
            ->getActiveSheet()
            ->getCell('F13')
            ->getCalculatedValue();

        return 0;
    }
}
