<?php

namespace RadDB\Console\Commands;

use PHPExcel;
use RadDB\Tube;
use RadDB\HVLData;
use RadDB\Machine;
use RadDB\TestDate;
use Illuminate\Console\Command;

class ImportFluoroSpreadsheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fluoro {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from fluoroscopy spreadsheet';

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
        $options = $this->option();
        $spreadsheetFile = $this->argument('file');

        // Read the spreadsheet
        echo "Loading spreadsheet\n";
        $reader = \PHPExcel_IOFactory::createReader('OOCalc');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $fluoroSheet = $spreadsheet->getSheetByName('Fluoro');

        // Get the survey ID
        $surveyId = (int) $fluoroSheet->getCell('F13')->getCalculatedValue();
        echo 'Saving data for survey ID: '.$surveyId."\n";

        // Pull info for this spreadsheet from the database
        $survey = TestDate::find(1939);
        $machine = Machine::find($survey->machine_id);
        $tubes = Tube::where('machine_id', $machine->id)->active()->get();

        // There might be more than one tube associated with this machine, so
        // ask the user which tube to associate this spreadsheet with
        if ($tubes->count() > 1) {
            $choice = "Enter the tube ID this spreadsheet belongs to\n";
            $tubeChoice = [];
            foreach ($tubes as $t) {
                $choice .= $t->id.': '.$t->insert_sn."\n";
                $tubeChoice[] = $t->id;
            }
            $tubeId = $this->choice($choice, $tubeChoice);
        } else {
            $tubeId = $tubes->first()->id;
        }

        // Get HVL
        $hvl = (float) $fluoroSheet->getCell('X174')->getCalculatedValue();
        $hvl_kv = (float) $fluoroSheet->getCell('F137')->getCalculatedValue();
        // Store HVL to database
        $HVLData = new HVLData();
        $HVLData->survey_id = $survey->id;
        $HVLData->machine_id = $machine->id;
        $HVLData->tube_id = $tubeId;
        $HVLData->kv = (float) $hvl_kv;
        $HVLData->hvl = (float) $hvl;
        $HVLData->save();
        echo "HVL data saved.\n";

        $fluoroEntranceExpRate = $fluoroSheet->rangeToArray('C205:M219', null, true, false, false);
        $maxFluoroEntraceExpRate = $fluoroSheet->rangeToArray('E220:M220', null, true, false, false);
        $fluoroReceptorEntrExpRate = $fluoroSheet->rangeToArray('C237:H251', null, true, false, false);
        $digEntranceExpRate = $fluoroSheet->rangeToArray('C271:M285', null, true, false, false);
        $maxDigEntranceExpRate = $fluoroSheet->rangeToArray('E286:M286', null, true, false, false);
        $digReceptorEntrExpRate = $fluoroSheet->rangeToArray('C300:H314', null, true, false, false);
    }
}
