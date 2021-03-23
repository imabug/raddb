<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use PHPExcel;
use RadDB\FluoroData;
use RadDB\HVLData;
use RadDB\Machine;
use RadDB\MachineSurveyData;
use RadDB\MaxFluoroData;
use RadDB\ReceptorEntranceExp;
use RadDB\TestDate;
use RadDB\Tube;

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
     * @return bool
     */
    public function handle()
    {
        $machineSurveyData = new MachineSurveyData();

        $options = $this->option();
        $spreadsheetFile = $this->argument('file');

        // Read the spreadsheet
        $this->info('Loading spreadsheet.');
        $reader = \PHPExcel_IOFactory::createReader('OOCalc');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $fluoroSheet = $spreadsheet->getSheetByName('Fluoro');
        $this->info('Spreadsheet loaded.');

        // Get the survey ID
        $surveyId = (int) $fluoroSheet->getCell('F13')->getCalculatedValue();

        // Pull info for this spreadsheet from the database
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);
        $tubes = Tube::where('machine_id', $machine->id)->active()->get();

        $machineSurveyData->survey_id = $survey->id;
        $machineSurveyData->machine_id = $machine->id;

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

        // Check to see if there's data for $surveyId in the hvldata table already
        if (HVLData::where('survey_id', $surveyId)->where('tube_id', $tubeId)->get()->count() > 0) {
            $this->error('Fluoro data already exists for this survey. Terminating.');

            return false;
        }

        $this->info('Saving data for survey ID: '.$surveyId);

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
        $machineSurveyData->hvldata = 1;
        $this->info('HVL data saved.');

        // Get image receptor field sizes (cm)
        $fieldSizes[0] = $fluoroSheet->getCell('O110')->getCalculatedValue();
        $fieldSizes[1] = $fluoroSheet->getCell('O113')->getCalculatedValue();
        $fieldSizes[2] = $fluoroSheet->getCell('O116')->getCalculatedValue();
        $fieldSizes[3] = $fluoroSheet->getCell('O119')->getCalculatedValue();
        $fieldSizes[4] = $fluoroSheet->getCell('O122')->getCalculatedValue();

        // Get dose modes
        $doseModes[0] = $fluoroSheet->getCell('Q107')->getCalculatedValue();
        $doseModes[1] = $fluoroSheet->getCell('T107')->getCalculatedValue();
        $doseModes[2] = $fluoroSheet->getCell('W107')->getCalculatedValue();

        // Get fluoro entrance exposure rate data
        $entranceExpRate = $fluoroSheet->rangeToArray('P109:Y123', null, true, false, false);
        $maxEntraceExpRate = $fluoroSheet->rangeToArray('Q124:Y124', null, true, false, false);

        // Store entrance exposure rate data
        $j = 0;
        foreach ($fieldSizes as $fs) {
            for ($i = 0; $i <= 2; $i++) {
                $fluoroData = new FluoroData();
                $fluoroData->survey_id = $survey->id;
                $fluoroData->machine_id = $machine->id;
                $fluoroData->tube_id = $tubeId;
                $fluoroData->field_size = $fs;
                $fluoroData->atten = $entranceExpRate[$i][0];
                $fluoroData->dose1_mode = $doseModes[0];
                $fluoroData->dose1_kv = round($entranceExpRate[$j + $i][1], 1);
                $fluoroData->dose1_ma = round($entranceExpRate[$j + $i][2], 1);
                $fluoroData->dose1_rate = round($entranceExpRate[$j + $i][3], 3);
                $fluoroData->dose2_mode = $doseModes[1];
                $fluoroData->dose2_kv = round($entranceExpRate[$j + $i][4], 1);
                $fluoroData->dose2_ma = round($entranceExpRate[$j + $i][5], 1);
                $fluoroData->dose2_rate = round($entranceExpRate[$j + $i][6], 3);
                $fluoroData->dose3_mode = $doseModes[2];
                $fluoroData->dose3_kv = round($entranceExpRate[$j + $i][7], 1);
                $fluoroData->dose3_ma = round($entranceExpRate[$j + $i][8], 1);
                $fluoroData->dose3_rate = round($entranceExpRate[$j + $i][9], 3);
                $fluoroData->save();
            }
            $j += 3;
        }
        $machineSurveyData->fluorodata = 1;
        $this->info('Fluoro entrance exposure rates saved.');

        // Store max entrance exposure rates
        $max = new MaxFluoroData();
        $max->survey_id = $survey->id;
        $max->machine_id = $machine->id;
        $max->tube_id = $tubeId;
        $max->dose1_kv = round($maxEntraceExpRate[0][0], 1);
        $max->dose1_ma = round($maxEntraceExpRate[0][1], 1);
        $max->dose1_rate = round($maxEntraceExpRate[0][2], 3);
        $max->dose2_kv = round($maxEntraceExpRate[0][3], 1);
        $max->dose2_ma = round($maxEntraceExpRate[0][4], 1);
        $max->dose2_rate = round($maxEntraceExpRate[0][5], 3);
        $max->dose3_kv = round($maxEntraceExpRate[0][6], 1);
        $max->dose3_ma = round($maxEntraceExpRate[0][7], 1);
        $max->dose3_rate = round($maxEntraceExpRate[0][8], 3);
        $max->save();
        $machineSurveyData->maxfluorodata = 1;
        $this->info('Max fluoro entrance exposure rates saved.');

        // Get pulse/digital entrance exposure rate data
        $doseModes[0] = $fluoroSheet->getCell('Q139')->getCalculatedValue();
        $doseModes[1] = $fluoroSheet->getCell('T139')->getCalculatedValue();
        $doseModes[2] = $fluoroSheet->getCell('W139')->getCalculatedValue();
        $entranceExpRate = $fluoroSheet->rangeToArray('P141:Y155', null, true, false, false);
        $maxEntraceExpRate = $fluoroSheet->rangeToArray('Q156:Y156', null, true, false, false);

        // Store entrance exposure rate data
        $j = 0;
        foreach ($fieldSizes as $fs) {
            for ($i = 0; $i <= 2; $i++) {
                $fluoroData = new FluoroData();
                $fluoroData->survey_id = $survey->id;
                $fluoroData->machine_id = $machine->id;
                $fluoroData->tube_id = $tubeId;
                $fluoroData->field_size = $fs;
                $fluoroData->atten = $entranceExpRate[$i][0];
                $fluoroData->dose1_mode = $doseModes[0];
                $fluoroData->dose1_kv = round($entranceExpRate[$j + $i][1], 1);
                $fluoroData->dose1_ma = round($entranceExpRate[$j + $i][2], 1);
                $fluoroData->dose1_rate = round($entranceExpRate[$j + $i][3], 3);
                $fluoroData->dose2_mode = $doseModes[1];
                $fluoroData->dose2_kv = round($entranceExpRate[$j + $i][4], 1);
                $fluoroData->dose2_ma = round($entranceExpRate[$j + $i][5], 1);
                $fluoroData->dose2_rate = round($entranceExpRate[$j + $i][6], 3);
                $fluoroData->dose3_mode = $doseModes[2];
                $fluoroData->dose3_kv = round($entranceExpRate[$j + $i][7], 1);
                $fluoroData->dose3_ma = round($entranceExpRate[$j + $i][8], 1);
                $fluoroData->dose3_rate = round($entranceExpRate[$j + $i][9], 3);
                $fluoroData->save();
            }
            $j += 3;
        }
        $this->info('Pulse/digital entrance exposure rates saved.');

        // Store max entrance exposure rates
        $max = new MaxFluoroData();
        $max->survey_id = $survey->id;
        $max->machine_id = $machine->id;
        $max->tube_id = $tubeId;
        $max->dose1_kv = round($maxEntraceExpRate[0][0], 1);
        $max->dose1_ma = round($maxEntraceExpRate[0][1], 1);
        $max->dose1_rate = round($maxEntraceExpRate[0][2], 3);
        $max->dose2_kv = round($maxEntraceExpRate[0][3], 1);
        $max->dose2_ma = round($maxEntraceExpRate[0][4], 1);
        $max->dose2_rate = round($maxEntraceExpRate[0][5], 3);
        $max->dose3_kv = round($maxEntraceExpRate[0][6], 1);
        $max->dose3_ma = round($maxEntraceExpRate[0][7], 1);
        $max->dose3_rate = round($maxEntraceExpRate[0][8], 3);
        $max->save();
        $this->info('Max pulse/digital entrance exposure rates saved.');

        // Get dose modes
        $doseModes[0] = $fluoroSheet->getCell('Q107')->getCalculatedValue();
        $doseModes[1] = $fluoroSheet->getCell('T107')->getCalculatedValue();
        $doseModes[2] = $fluoroSheet->getCell('W107')->getCalculatedValue();

        // Get receptor entrance exposure rate data
        $receptorEntrExpRate = $fluoroSheet->rangeToArray('P190:T204', null, true, false, false);
        foreach ($receptorEntrExpRate as $k => $r) {
            $ree = new ReceptorEntranceExp();
            $ree->survey_id = $survey->id;
            $ree->machine_id = $machine->id;
            $ree->tube_id = $tubeId;
            $ree->field_size = $r[0];
            $ree->mode = $doseModes[floor($k / 5)];
            $ree->kv = $r[1];
            $ree->ma = $r[2];
            $ree->rate = $r[4];
            $ree->save();
        }
        $this->info('Fluoro recepter entrance exposure rates stored.');

        // Get pulse/digital entrance exposure rate data
        $doseModes[0] = $fluoroSheet->getCell('Q139')->getCalculatedValue();
        $doseModes[1] = $fluoroSheet->getCell('T139')->getCalculatedValue();
        $doseModes[2] = $fluoroSheet->getCell('W139')->getCalculatedValue();

        // Get pulse/digital entrance exposure rate data
        $receptorEntrExpRate = $fluoroSheet->rangeToArray('P214:T228', null, true, false, false);
        foreach ($receptorEntrExpRate as $k => $r) {
            $ree = new ReceptorEntranceExp();
            $ree->survey_id = $survey->id;
            $ree->machine_id = $machine->id;
            $ree->tube_id = $tubeId;
            $ree->field_size = $r[0];
            $ree->mode = $doseModes[floor($k / 5)];
            $ree->kv = $r[1];
            $ree->ma = $r[2];
            $ree->rate = $r[4];
            $ree->save();
        }
        $machineSurveyData->receptorentrance = 1;
        $this->info('Pulse/digital receptor entrance exposure rates stored.');

        $machineSurveyData->save();

        return 1;
    }
}
