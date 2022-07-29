<?php

namespace App\Console\Commands;

use App\Models\GenData;
use App\Models\Machine;
use App\Models\TestDate;
use App\Models\Tube;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportGenData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:gendata
                            {file : Excel spreadsheet to load generator data from}';

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

        $reader = new Xlsx();
        $spreadsheet = new Spreadsheet();

        $spreadsheet = $reader
            ->setReadDataOnly(true)
            ->setLoadSheetsOnly(['Gen_form', 'Sheet1'])
            ->load($surveyFile);

        $progressBar->advance();

        // Get the survey ID (cell E14)
        $surveyId = $spreadsheet
            ->getActiveSheet()
            ->getCell('E14')
            ->getCalculatedValue();

        // Check to see if data for this survey ID already exists.
        if (GenData::where('survey_id', $surveyId)->get()->count() > 0) {
            // There's already data for this $surveyId present.  Exit.
            $progressBar->finish();
            $this->newLine();
            $this->info('Generator data for this survey already exists.  Exiting');

            return 1;
        }

        // Get test date data
        $testDate = TestDate::with('machine')
            ->find($surveyId);

        // Get machine information
        $machine = $testDate->machine;

        // Get tube information.  Only active tubes are retrieved.
        // This means the command will error out if we try to add
        // generator data for an inactive/removed tube.
        // There will usually be only one tube, but for RF rooms,
        // need to make sure we get the radiographic tube
        $tubes = Tube::active()
            ->where('machine_id', $machine->id)
            ->get();

        if ($tubes->count() > 1) {
            // More than one tube for this machine.
            // Ask the user which tube should be associated with the generator data
            $this->newLine();
            foreach ($tubes as $tube) {
                $this->line($tube->id.': '.$tube->housing_model.' SN: '.$tube->housing_sn.' '.$tube->notes);
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
         * AP: Exposure time (seconds)
         * AQ: Dose (mGy)
         * AR: Dose rate (mGy/s)
         * AS: Filtration (mm Al)
         * AT: Half value layer (mm Al)
         */
        foreach ($genData as $row) {
            if (!is_numeric($row['AO'])) {
                // No measurement here, so we can skip this row
                continue;
            }
            $g = new GenData();
            $g->survey_id = $surveyId;
            $g->tube_id = $tubeId;
            $g->machine_id = $machine->id;
            $g->kv_set = $row['AC'];
            $g->ma_set = $row['AD'];
            $g->time_set = $row['AE'];
            $g->mas_set = $row['AF'];
            $g->add_filt = $row['AG'];
            $g->kv_eff = $row['AO'];
            $g->exp_time = $row['AP'] / 1000;  // Convert measured exposure time to seconds
            $g->exposure = $row['AQ'];
            $g->dose_rate = $row['AR'];
            $g->tot_filt = $row['AS'];
            $g->hvl = $row['AT'];

            $g->save();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Generator data for Survey ID: '.$surveyId.' ('.$machine->description.') saved.');

        return 1;
    }
}
