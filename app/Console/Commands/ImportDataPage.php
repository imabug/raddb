<?php

namespace RadDB\Console\Commands;

use PHPExcel;
use RadDB\Tube;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\FluoroData;
use RadDB\MaxFluoroData;
use RadDB\RadSurveyData;
use RadDB\CollimatorData;
use RadDB\RadiationOutput;
use RadDB\MachineSurveyData;
use RadDB\ReceptorEntranceExp;
use Illuminate\Console\Command;

class ImportDataPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sheet {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the DataPage from a spreadsheet';

    /**
     * Array of spreadsheet types
     *
     * @var array
     */
    protected $sheetType = [
        "RAD",
        "FLUORO",
        "MAMMO_HOL",
        "MAMMO_SIE",
        "SBB",
    ];

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
        $options = $this->option();
        $spreadsheetFile = $this->argument('file');

        // Get the file extension
        list($file, $ext) = explode('.', $spreadsheetFile);

        // Read the spreadsheet
        $this->info('Loading spreadsheet');
        switch($ext) {
            case 'xls':
            case 'xlsx':
            case 'xlsm':
                $reader = \PHPExcel_IOFactory::createReader('Excel2007');
                break;
            case 'ods':
                $reader = \PHPExcel_IOFactory::createReader('OOCalc');
                break;
            default:
                $this->error('Invalid spreadsheet format. File must be an Excel or LibreOffice spreadsheet.');
                break;
        }
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $dataPage = $spreadsheet->getSheetByName('DataPage');
        if (is_null($dataPage)) {
            $this->error('Spreadsheet has no DataPage');

            return false;
        }
        else {
            $this->info('Spreadsheet loaded.');
        }

        // Figure out what type of spreadsheet has been loaded
        $sheetType = $dataPage->getCell('B1')->getCalculatedValue();

        // Pull info for this spreadsheet from the database
        // Get the survey ID
        $surveyId = (int) $dataPage->getCell('B2')->getCalculatedValue();

        switch($sheetType) {
            case 'RAD':
                $status = $this->importRad($surveyId, $dataPage);
                break;
            case 'FLUORO':
                $status = $this->importFluoro($surveyId, $dataPage);
                break;
            case 'MAMMO_HOL':
                $status = $this->importMammoHol($surveyId, $dataPage);
                break;
            case 'MAMMO_SIE':
                $status = $this->importMammoSie($surveyId, $dataPage);
                break;
            case 'SBB':
                $status = $this->importSbb($surveyId, $dataPage);
                break;
            default:
                $this->error('Not a compatible spreadsheet');
                break;
        }

        return $status;
    }

    /**
     * Ask for tube ID.
     * There might be more than one tube associated with this machine, so
     * ask the user which tube to associate this spreadsheet with
     *
     * @param int $machineId
     * @return int $tubeId
     */
    private function askTubeId($machineId)
    {
        $tubes = Tube::where('machine_id', $machineId)->active()->get();
        if ($tubes->count() > 1) {
            $choice = "Enter the tube ID this spreadsheet belongs to\n";
            $tubeChoice = [];
            foreach ($tubes as $t) {
                $choice .= $t->id.': '.$t->insert_sn."\n";
                $tubeChoice[] = $t->id;
            }
            return $this->choice($choice, $tubeChoice);
        } else {
            return $tubes->first()->id;
        }
    }

    /**
     * Import radiography spreadsheet data
     *
     * @param int $surveyId
     * @param array $dataPage
     * @return bool
     */
    private function importRad($surveyId, $dataPage)
    {
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);

        $machineSurveyData = new MachineSurveyData();

        $machineSurveyData->survey_id = $survey->id;
        $machineSurveyData->machine_id = $machine->id;

        $tubeId = $this->askTubeId($machine->id);

        // Check to see if there's data for $surveyId in the GenData table already
        if (GenData::surveyId($surveyId)->where('tube_id', $tubeId)->get()->count() > 0) {
            $this->error('Generator data already exists for this survey. Terminating.');

            return false;
        }

        $this->info('Saving data for survey ID: '.$surveyId);

        // SID Indicator accuracy error.
        $sidAccuracyError = $dataPage->getCell('G484')->getCalculatedValue();

        // Average illumination in lux.
        $avgIllumination = $dataPage->getCell('I504')->getCalculatedValue();

        // Beam alignment error.
        $beamAlignmentErr = $dataPage->getCell('G537')->getCalculatedValue();

        // Radiation/film center distance (cm) for table bucky.
        $radFilmCenterTable = $dataPage->getCell('C547')->getCalculatedValue();

        // Radiation/film center distance (cm) for wall bucky.
        $radFilmCenterWall = $dataPage->getCell('C608')->getCalculatedValue();

        // Large/small focal spot resolution (lp/mm)
        $lfsResolution = $dataPage->getCell('I672')->getCalculatedValue();
        $sfsResolution = $dataPage->getCell('I677')->getCalculatedValue();

        // Insert the above data into the radsurveydata table
        $radSurvey = new RadSurveyData();
        $radSurvey->survey_id = $survey->id;
        $radSurvey->machine_id = $machine->id;
        $radSurvey->tube_id = $tubeId;
        $radSurvey->sid_accuracy_error = (float) $sidAccuracyError;
        $radSurvey->avg_illumination = (float) $avgIllumination;
        $radSurvey->beam_alignment_error = (float) $beamAlignmentErr;
        $radSurvey->rad_film_center_table = (float) $radFilmCenterTable;
        $radSurvey->rad_film_center_wall = (float) $radFilmCenterWall;
        $radSurvey->lfs_resolution = (float) $lfsResolution;
        $radSurvey->sfs_resolution = (float) $sfsResolution;
        $radSurvey->save();
        $machineSurveyData->radsurveydata = 1;
        $this->info('Radiographic survey data saved.');

        // Table bucky SID (cm)
        $tableSid = $dataPage->getCell('K543')->getCalculatedValue();

        // Wall bucky SID (cm)
        $wallSid = $dataPage->getCell('C615')->getCalculatedValue();

        // Field size indicators, radiation/light field alignment for table bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationTable = $dataPage->rangeToArray('B554:G555', null, true, false, false);

        // Automatic collimation (PBL) for table bucky
        // First pair - Cassette size (cm)
        $pblTable = $dataPage->rangeToArray('B575:C576', null, true, false, false);

        // Field size indicators, radiation/light field alignment for wall bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationWall = $dataPage->rangeToArray('D615:I616', null, true, false, false);

        // Automatic collimation (PBL) for wall bucky
        // First pair - Cassette size (cm)
        $pblWall = $dataPage->rangeToArray('C637:D638', null, true, false, false);

        // Insert the collimator data into the database
        // Table receptor
        for ($i = 0; $i <= 1; $i++) {
            $collimatorData = new CollimatorData();
            $collimatorData->survey_id = $survey->id;
            $collimatorData->machine_id = $machine->id;
            $collimatorData->tube_id = $tubeId;
            $collimatorData->sid = $tableSid;
            $collimatorData->receptor = 'Table';
            $collimatorData->indicated_trans = $collimationTable[$i][0] == 'NA' ? null : (float) $collimationTable[$i][0];
            $collimatorData->indicated_long = $collimationTable[$i][1] == 'NA' ? null : (float) $collimationTable[$i][1];
            $collimatorData->rad_trans = $collimationTable[$i][2] == 'NA' ? null : (float) $collimationTable[$i][2];
            $collimatorData->rad_long = $collimationTable[$i][3] == 'NA' ? null : (float) $collimationTable[$i][3];
            $collimatorData->light_trans = $collimationTable[$i][4] == 'NA' ? null : (float) $collimationTable[$i][4];
            $collimatorData->light_long = $collimationTable[$i][5] == 'NA' ? null : (float) $collimationTable[$i][5];
            $collimatorData->pbl_trans = $pblTable[$i][0] == 'NA' ? null : (float) $pblTable[$i][0];
            $collimatorData->pbl_long = $pblTable[$i][1] == 'NA' ? null : (float) $pblTable[$i][1];
            $collimatorData->save();
        }
        $this->info('Table receptor collimator data saved');

        // Wall receptor
        for ($i = 0; $i <= 1; $i++) {
            $collimatorData = new CollimatorData();
            $collimatorData->survey_id = $survey->id;
            $collimatorData->machine_id = $machine->id;
            $collimatorData->tube_id = $tubeId;
            $collimatorData->sid = $wallSid;
            $collimatorData->receptor = 'Wall';
            $collimatorData->indicated_trans = $collimationWall[$i][0] == 'NA' ? null : (float) $collimationWall[$i][0];
            $collimatorData->indicated_long = $collimationWall[$i][1] == 'NA' ? null : (float) $collimationWall[$i][1];
            $collimatorData->rad_trans = $collimationWall[$i][2] == 'NA' ? null : (float) $collimationWall[$i][2];
            $collimatorData->rad_long = $collimationWall[$i][3] == 'NA' ? null : (float) $collimationWall[$i][3];
            $collimatorData->light_trans = $collimationWall[$i][4] == 'NA' ? null : (float) $collimationWall[$i][4];
            $collimatorData->light_long = $collimationWall[$i][5] == 'NA' ? null : (float) $collimationWall[$i][5];
            $collimatorData->pbl_trans = $pblWall[$i][0] == 'NA' ? null : (float) $pblWall[$i][0];
            $collimatorData->pbl_long = $pblWall[$i][1] == 'NA' ? null : (float) $pblWall[$i][1];
            $collimatorData->save();
        }
        $machineSurveyData->collimatordata = 1;
        $this->info('Wall receptor collimator data saved');

        // Large/small focus radiation output
        // Measured kV, mGy/mAs @ 40"
        $lfsOutput = $dataPage->rangeToArray('D1394:E1401', null, true, false, false);
        $sfsOutput = $dataPage->rangeToArray('D1407:E1412', null, true, false, false);

        // Insert the radiation output data into tthe database
        foreach ($lfsOutput as $l) {
            $radOutput = new RadiationOutput();
            // Skip the record if it's empty
            if (empty($l[0])) {
                continue;
            }
            $radOutput->survey_id = $survey->id;
            $radOutput->machine_id = $machine->id;
            $radOutput->tube_id = $tubeId;
            $radOutput->focus = 'Large';
            $radOutput->kv = (float) $l[0];
            $radOutput->output = (float) $l[1];
            $radOutput->save();
        }
        $this->info('Large focus output data saved.');
        foreach ($sfsOutput as $s) {
            $radOutput = new RadiationOutput();
            // Skip the record if it's empty
            if (empty($s[0])) {
                continue;
            }
            $radOutput->survey_id = $survey->id;
            $radOutput->machine_id = $machine->id;
            $radOutput->tube_id = $tubeId;
            $radOutput->focus = 'Small';
            $radOutput->kv = (float) $s[0];
            $radOutput->output = (float) $s[1];
            $radOutput->save();
        }
        $machineSurveyData->radoutputdata = 1;
        $this->info('Small focus output data saved.');

        // Load generator test data from cells AA688:BB747 into an array
        $genTestData = $dataPage->rangeToArray('AA688:BB747', null, true, false, true);

        // Insert generator test data into the database
        foreach ($genTestData as $genDataRow) {
            // Skip the record if it's empty
            if (empty($genDataRow['AZ'])) {
                continue;
            }

            $genData = new GenData();
            $genData->survey_id = $survey->id;
            $genData->machine_id = $machine->id;
            $genData->tube_id = $tubeId;
            $genData->kv_set = (int) $genDataRow['AA'];
            $genData->ma_set = (int) $genDataRow['AB'];
            $genData->time_set = (float) $genDataRow['AC'];
            $genData->mas_set = (float) $genDataRow['AD'];
            $genData->add_filt = (float) $genDataRow['AF'];
            $genData->distance = (int) $genDataRow['AH'];

            // Take the linearity, accuracy, beam quality and reproducibility flags
            // from the table and pack it all into one byte
            // bit 0 - linearity
            // bit 1 - accuracy
            // bit 2 - beam quality
            // bit 3 - reproducibility
            //
            // Columns 17-19,21 contain 1 if the current row is used for that
            // particular measurement, and 0 if it isn't.
            $genData->use_flags = (($genDataRow['AQ'] ? self::LINEARITY : 0) |
                                   ($genDataRow['AR'] ? self::ACCURACY : 0) |
                                   ($genDataRow['AS'] ? self::BEAMQUAL : 0) |
                                   ($genDataRow['AU'] ? self::REPRO : 0));

            // Columns 24-28 contain the actual measurements.
            // If there is no value, then store null
            $genData->kv_avg = empty($genDataRow['AX']) ? null : (float) $genDataRow['AX'];
            $genData->kv_max = empty($genDataRow['AY']) ? null : (float) $genDataRow['AY'];
            $genData->kv_eff = empty($genDataRow['AZ']) ? null : (float) $genDataRow['AZ'];
            $genData->exp_time = empty($genDataRow['BA']) ? null : (float) $genDataRow['BA'];
            $genData->exposure = empty($genDataRow['BB']) ? null : (float) $genDataRow['BB'];

            // Store the data
            $genData->save();
        }
        $machineSurveyData->gendata = 1;
        $this->info('Generator test data saved.');

        // Get half value layer data
        // kV, HVL (mm Al)
        $hvls = $dataPage->rangeToArray('Y969:Z978', null, true, false, false);

        // Insert the HVL data into the database
        foreach ($hvls as $hvl) {
            $HVLData = new HVLData();
            $HVLData->survey_id = $survey->id;
            $HVLData->machine_id = $machine->id;
            $HVLData->tube_id = $tubeId;
            if (empty($hvl[0]) || empty($hvl[1])) {
                // Skip the record if it's empty
                continue;
            }
            $HVLData->kv = (float) $hvl[0];
            $HVLData->hvl = (float) $hvl[1];
            $HVLData->save();
        }
        $machineSurveyData->hvldata = 1;
        $this->info('HVL data saved.');

        $machineSurveyData->save();

        return true;
    }

    /**
     * Import fluoroscopy spreadsheet data
     *
     * @param int $surveyID
     * @param array $dataPage
     * @return bool
     */
    private function importFluoro($surveyId, $dataPage)
    {
        // Pull info for this spreadsheet from the database
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);
        $tubes = Tube::where('machine_id', $machine->id)->active()->get();

        $machineSurveyData = new MachineSurveyData();

        $machineSurveyData->survey_id = $survey->id;
        $machineSurveyData->machine_id = $machine->id;

        $tubeId = $this->askTubeId($machine->id);

        // Check to see if there's data for $surveyId in the hvldata table already
        if (HVLData::where('survey_id', $surveyId)->where('tube_id', $tubeId)->get()->count() > 0) {
            $this->error('Fluoro data already exists for this survey. Terminating.');

            return false;
        }

        $this->info('Saving data for survey ID: '.$surveyId);

        // Get HVL
        $hvl = (float) $dataPage->getCell('X174')->getCalculatedValue();
        $hvl_kv = (float) $dataPage->getCell('F137')->getCalculatedValue();

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
        $fieldSizes[0] = $dataPage->getCell('O110')->getCalculatedValue();
        $fieldSizes[1] = $dataPage->getCell('O113')->getCalculatedValue();
        $fieldSizes[2] = $dataPage->getCell('O116')->getCalculatedValue();
        $fieldSizes[3] = $dataPage->getCell('O119')->getCalculatedValue();
        $fieldSizes[4] = $dataPage->getCell('O122')->getCalculatedValue();

        // Get dose modes
        $doseModes[0] = $dataPage->getCell('Q107')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('T107')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('W107')->getCalculatedValue();

        // Get fluoro entrance exposure rate data
        $entranceExpRate = $dataPage->rangeToArray('P109:Y123', null, true, false, false);
        $maxEntraceExpRate = $dataPage->rangeToArray('Q124:Y124', null, true, false, false);

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
        $doseModes[0] = $dataPage->getCell('Q139')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('T139')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('W139')->getCalculatedValue();
        $entranceExpRate = $dataPage->rangeToArray('P141:Y155', null, true, false, false);
        $maxEntraceExpRate = $dataPage->rangeToArray('Q156:Y156', null, true, false, false);

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
        $doseModes[0] = $dataPage->getCell('Q107')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('T107')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('W107')->getCalculatedValue();

        // Get receptor entrance exposure rate data
        $receptorEntrExpRate = $dataPage->rangeToArray('P190:T204', null, true, false, false);
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
        $doseModes[0] = $dataPage->getCell('Q139')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('T139')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('W139')->getCalculatedValue();

        // Get pulse/digital entrance exposure rate data
        $receptorEntrExpRate = $dataPage->rangeToArray('P214:T228', null, true, false, false);
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

        return true;
    }

    /**
     * Import mammography (Hologic) spreadsheet data
     *
     * @param int $surveyID
     * @param array $dataPage
     * @return bool
     */
    private function importMammoHol($surveyId, $dataPage)
    {

    }
    /**
     * Import mammography (Siemens) spreadsheet data
     *
     * @param int $surveyID
     * @param array $dataPage
     * @return bool
     */
    private function importMammoSie($surveyId, $dataPage)
    {

    }
    /**
     * Import SBB spreadsheet data
     *
     * @param int $surveyID
     * @param array $dataPage
     * @return bool
     */
    private function importSbb($surveyId, $dataPage)
    {

    }
}
