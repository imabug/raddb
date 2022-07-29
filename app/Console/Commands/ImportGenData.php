<?php

namespace App\Console\Commands;

use App\Models\GenData;
use App\Models\Machine;
use App\Models\TestDate;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportGenData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:gendata
                            {file : Excel spreadsheet to load generator data from}
                            {--data=? : Excel cell range of the generator data (e.g. A1:B2)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import generator data from the specified Excel spreadsheet';

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
        if (!is_null($this->option('data'))) {
            $dataBlock = $this->option('data');
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = new Spreadsheet();

        $reader->setReadDataOnly(true)
            ->setLoadSheetsOnly(['Gen_form', 'Sheet1']);

        $spreadsheet = $reader->load($surveyFile);

        $progressBar->advance();

        // Get the survey ID (cell E14)
        $surveyId = $spreadsheet
            ->getActiveSheet()
            ->getCell('E14')
            ->getCalculatedValue();

        // Get test date data
        $testDate = TestDate::with('machine')
            ->find($surveyId);

        // Get machine information
        $machine = $testDate->machine;

        // Get tube information
        // There will usually be only one tube, but for RF rooms,
        // need to make sure we get the radiographic tube
        if ($machine->tube->count() > 1) {
            $tube = $machine->tube->where('notes', 'Radiographic tube');
        } else {
            $tube = $machine->tube->first();
        }

        // Load the generator data in block AC637:AT678
        $genData = $spreadsheet
            ->getActiveSheet()
            ->rangeToArray(
                'AC637:AT678',
                null,
                true,
                true,
                true
            );

        $progressBar->advance();

        /*
         * Insert the data into the database
         *
         * AC: Set kV
         * AD: Set mA
         * AE: Exposure time (seconds)
         * AF: Set mAs
         * AG: Added filtration
         * AH - AN: Unused for generator data acquired using the RTI Barracuda/Piranha
         * AO: Measured kV
         * AP: Exposure time (ms)
         * AQ: Dose (mGy)
         * AR: Dose rate (mGy/s)
         * AS: Filtration (mm Al)
         * AT: Half value layer (mm Al)
         */
        foreach ($genData as $row) {
            if (!is_numeric($row['AO'])) {
                // No measurement here, so we can skip this row
                break;
            }
            $g = new GenData();
            $g->survey_id = $surveyId;
            $g->tube_id = $tube->id;
            $g->machine_id = $machine->id;
            $g->kv_set = $row['AC'];
            $g->ma_set = $row['AD'];
            $g->time_set = $row['AE'];
            $g->mas_set = $row['AF'];
            $g->add_filt = $row['AG'];
            $g->kv_eff = $row['AO'];
            $g->exp_time = $row['AP'] / 1000;
            $g->exposure = $row['AQ'];
            $g->dose_rate = $row['AR'];
            $g->tot_filt = $row['AS'];
            $g->hvl = $row['AT'];

            $g->save();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info('Generator data for Survey ID: '.$surveyId.' ('.$machine->description.') saved.');

        return 1;
    }
}
