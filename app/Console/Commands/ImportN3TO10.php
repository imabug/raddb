<?php

namespace App\Console\Commands;

use App\Models\LeedsN3;
use App\Models\LeedsTO10;
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
            ->setLoadSheetsOnly(['Fluoro'])
            ->load($surveyFile);

        $progressBar->advance();

        // Get the survey ID (cell F13)
        $surveyId = $spreadsheet
            ->getActiveSheet()
            ->getCell('F13')
            ->getCalculatedValue();

        // Check to see if data for this survey ID already exists.
        if ((LeedsN3::where('survey_id', $surveyId)->get()->count() > 0) &&
            (LeedsTO10::where('survey_id', $surveyId)->get()->count() > 0)) {
            // There's already data for this $surveyId present.  Exit
            $progressBar->finish();
            $this->newLine();
            $this->info('Leeds N3 and TO.10 data for this survey already exists.  Exiting');

            return 1;
        }

        // Get test date data
        $testDate = TestDate::with('machine')
            ->find($surveyId);

        // Get machine information
        $machine = $testDate->machine;

        // Get tube information.
        // There will usually be only one tube, but for RF rooms,
        // need to make sure we get the radiographic tube
        $tubes = Tube::where('machine_id', $machine->id)->get();

        if ($tubes->count() > 1) {
            // More than one tube for this machine.
            // Ask the user which tube should be associated with the generator data
            $this->newLine();
            foreach ($tubes as $tube) {
                $this->line($tube->id.': '.$tube->housing_model.' SN: '.$tube->housing_sn.' '.$tube->notes.' Status:'.$tube->tube_status);
                $tubeChoice[] = $tube->id;
            }
            $tubeId = $this->choice(
                'Select the tube to associate ',
                $tubeChoice,
                $defaultIndex = 0,
                $maxAttempts = null,
                $allowMultipleSelections = false
            );
        } else {
            $tubeId = $tubes->first()->id;
        }

        $progressBar->advance();

        // Get Leeds test data (D401:K405)
        // Field size is D401:D405
        // N3 data is J401:J405
        $leedsN3 = $spreadsheet
            ->getActiveSheet()
            ->rangeToArray(
                'D401:K405',
                null,
                true,
                true,
                true
            );
        $progressBar->advance();

        /*
         * Insert N3 data into the database
         *
         * D: field size
         * J: N3 data
         */
        foreach ($leedsN3 as $row) {
            if (!is_numeric($row['D'])) {
                // No measurement here, so we can skip this row
                continue;
            }
            $n3 = new LeedsN3;
            $n3->survey_id = $surveyId;
            $n3->machine_id = $machine->id;
            $n3->tube_id = $tubeId;
            $n3->field_size = $row['D'];
            $n3->n3 = $row['J'];

            $n3->save();
            $progressBar->advance();
        }

        $this->info(' Leeds N3 data for Survey ID: '.$surveyId.' ('.$machine->description.') saved.');

        /*
         * Get Leeds TO10 data (C414:M426)
         * Contrast detail
         * Field size: D414-H414
         * CD data: D415:H426
         * Threshold index
         * Field size: I414:M414
         * TI data: I415:M426
        */
        $leeds_to10 = $spreadsheet
            ->getActiveSheet()
            ->rangeToArray(
                'C414:M426',
                null,
                true,
                true,
                true
            );
        $progressBar->advance();

        /*
         * Insert TO.10 data into the database
         */

        $progressBar->finish();

        return 0;
    }
}
