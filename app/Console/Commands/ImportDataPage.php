<?php

namespace RadDB\Console\Commands;

use PHPExcel;
use RadDB\Tube;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\LeedsN3;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\FluoroData;
use RadDB\LeedsTO10CD;
use RadDB\LeedsTO10TI;
use RadDB\MaxFluoroData;
use RadDB\RadSurveyData;
use RadDB\CollimatorData;
use RadDB\RadiationOutput;
use RadDB\FluoroResolution;
use RadDB\MachineSurveyData;
use RadDB\ReceptorEntranceExp;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Ods;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
     * Array for survey data that will be passed to the methods importing data
     *
     * @var array
     */
    protected $surveyData = [
        'surveyId' => '',
        'machineId' => '',
        'tubeId' => '',
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
        switch ($ext) {
            case 'xls':
            case 'xlsx':
            case 'xlsm':
                $reader = new Xlsx();
                $this->info('Loading Excel spreadsheet');
                break;
            case 'ods':
                $reader = new Ods();
                $this->info('Loading OpenOffice/LibreOffice spreadsheet');
                break;
            default:
                $this->error('Invalid spreadsheet format. File must be an Excel or LibreOffice spreadsheet.');
                break;
        }
        $reader->setReadDataOnly(true);
        try {
            $spreadsheet = $reader->load($spreadsheetFile);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading file: '.$e->getMessage());
        }
        $this->info('Spreadsheet loaded.');

        try {
            $dataPage = $spreadsheet->getSheetByName('DataPage');
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading DataPage: '.$e->getMessage());
        }
        $this->info('Spreadsheet loaded.');

        // Figure out what type of spreadsheet has been loaded
        $sheetType = $dataPage->getCell('B1')->getCalculatedValue();

        // Get the survey data for this spreadsheet
        $surveyData['surveyId'] = $dataPage->getCell('B2')->getCalculatedValue();
        $survey = TestDate::find($surveyData['surveyId']);
        $surveyData['machineId'] = $survey->machine_id;
        $surveyData['tubeId'] = $this->askTubeId($survey->machine_id);

        switch ($sheetType) {
            case 'RAD':
                $this->info('Processing ' . $sheetType. ' spreadsheet');
                $status = $this->importRad($surveyId, $dataPage);
                break;
            case 'FLUORO':
                $this->info('Processing ' . $sheetType. ' spreadsheet');
                $status = $this->importFluoro($surveyId, $dataPage);
                break;
            case 'MAMMO_HOL':
                $this->info('Processing ' . $sheetType. ' spreadsheet');
                $status = $this->importMammoHol($surveyId, $dataPage);
                break;
            case 'MAMMO_SIE':
                $this->info('Processing ' . $sheetType. ' spreadsheet');
                $status = $this->importMammoSie($surveyId, $dataPage);
                break;
            case 'SBB':
                $this->info('Processing ' . $sheetType. ' spreadsheet');
                $status = $this->importSbb($surveyId, $dataPage);
                break;
            default:
                $status = $this->error('Not a compatible spreadsheet');
                break;
        }

        return $status;
    }

    /**
     * Ask for tube ID.
     * There might be more than one tube associated with this machine, so
     * ask the user which tube to associate this spreadsheet with.
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
     * Import radiography spreadsheet data.
     *
     * @param int $surveyId
     * @param \PhpOffice\PhpSpreadsheet\Reader $dataPage
     * @return bool
     */
    private function importRad($surveyId, $dataPage)
    {
        $machineSurveyData = new MachineSurveyData();

        $machineSurveyData->survey_id = $survey->id;
        $machineSurveyData->machine_id = $machine->id;


        // Check to see if there's data for $surveyId in the GenData table already
        if (GenData::surveyId($surveyId)->where('tube_id', $tubeId)->get()->count() > 0) {
            $this->error('Generator data already exists for this survey. Terminating.');

            return false;
        }

        $this->info('Saving data for survey ID: '.$surveyId);

        // Insert the above data into the radsurveydata table
        $radSurvey = new RadSurveyData();
        $radSurvey->survey_id = $survey->id;
        $radSurvey->machine_id = $machine->id;
        $radSurvey->tube_id = $tubeId;
        $radSurvey->sid_accuracy_error = (float) $dataPage->getCell('B3')->getCalculatedValue();
        $radSurvey->avg_illumination = (float) $dataPage->getCell('B4')->getCalculatedValue();
        $radSurvey->beam_alignment_error = (float) $dataPage->getCell('B5')->getCalculatedValue();
        $radSurvey->rad_film_center_table = (float) $dataPage->getCell('B6')->getCalculatedValue();
        $radSurvey->rad_film_center_wall = (float) $dataPage->getCell('B7')->getCalculatedValue();
        $radSurvey->lfs_resolution = (float) $dataPage->getCell('B8')->getCalculatedValue();
        $radSurvey->sfs_resolution = (float) $dataPage->getCell('B9')->getCalculatedValue();
        $radSurvey->save();
        $machineSurveyData->radsurveydata = 1;
        $this->info('Radiographic survey data saved.');

        // Table bucky SID (cm)
        $tableSid = $dataPage->getCell('B10')->getCalculatedValue();

        // Wall bucky SID (cm)
        $wallSid = $dataPage->getCell('B11')->getCalculatedValue();

        // Field size indicators, radiation/light field alignment for table bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationTable = $dataPage->rangeToArray('B12:G13', null, true, false, false);

        // Automatic collimation (PBL) for table bucky
        // First pair - Cassette size (cm)
        $pblTable = $dataPage->rangeToArray('B14:C15', null, true, false, false);

        // Field size indicators, radiation/light field alignment for wall bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationWall = $dataPage->rangeToArray('B16:G17', null, true, false, false);

        // Automatic collimation (PBL) for wall bucky
        // First pair - Cassette size (cm)
        $pblWall = $dataPage->rangeToArray('B18:C19', null, true, false, false);

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
        $lfsOutput = $dataPage->rangeToArray('B20:C27', null, true, false, false);
        $sfsOutput = $dataPage->rangeToArray('B28:C33', null, true, false, false);

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
        $genTestData = $dataPage->rangeToArray('B34:AC93', null, true, false, true);

        // Insert generator test data into the database
        foreach ($genTestData as $genDataRow) {
            // Skip the record if it's empty
            if (empty($genDataRow['AA'])) {
                continue;
            }

            $genData = new GenData();
            $genData->survey_id = $survey->id;
            $genData->machine_id = $machine->id;
            $genData->tube_id = $tubeId;
            $genData->kv_set = (int) $genDataRow['B'];
            $genData->ma_set = (int) $genDataRow['C'];
            $genData->time_set = (float) $genDataRow['D'];
            $genData->mas_set = (float) $genDataRow['E'];
            $genData->add_filt = (float) $genDataRow['G'];
            $genData->distance = (int) $genDataRow['I'];

            // Take the linearity, accuracy, beam quality and reproducibility flags
            // from the table and pack it all into one byte
            // bit 0 - linearity
            // bit 1 - accuracy
            // bit 2 - beam quality
            // bit 3 - reproducibility
            //
            // Columns 17-19,21 contain 1 if the current row is used for that
            // particular measurement, and 0 if it isn't.
            $genData->use_flags = (($genDataRow['R'] ? self::LINEARITY : 0) |
                                   ($genDataRow['S'] ? self::ACCURACY : 0) |
                                   ($genDataRow['T'] ? self::BEAMQUAL : 0) |
                                   ($genDataRow['V'] ? self::REPRO : 0));

            // Columns 24-28 contain the actual measurements.
            // If there is no value, then store null
            $genData->kv_avg = empty($genDataRow['Y']) ? null : (float) $genDataRow['AX'];
            $genData->kv_max = empty($genDataRow['Z']) ? null : (float) $genDataRow['AY'];
            $genData->kv_eff = empty($genDataRow['AA']) ? null : (float) $genDataRow['AZ'];
            $genData->exp_time = empty($genDataRow['AB']) ? null : (float) $genDataRow['BA'];
            $genData->exposure = empty($genDataRow['AC']) ? null : (float) $genDataRow['BB'];

            // Store the data
            $genData->save();
        }
        $machineSurveyData->gendata = 1;
        $this->info('Generator test data saved.');

        // Get half value layer data
        // kV, HVL (mm Al)
        $hvls = $dataPage->rangeToArray('B94:C103', null, true, false, false);

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
     * Import fluoroscopy spreadsheet data.
     *
     * @param int $surveyId
     * @param \PhpOffice\PhpSpreadsheet\Reader $dataPage
     * @return bool
     */
    private function importFluoro($surveyId, $dataPage)
    {
        // Pull info for this spreadsheet from the database
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);
        $tubes = Tube::where('machine_id', $machine->id)->active()->get();

        $machineSurveyData = new MachineSurveyData();

        $machineSurveyData->id = $survey->id;
        $machineSurveyData->machine_id = $machine->id;

        $tubeId = $this->askTubeId($machine->id);

        // Check to see if there's data for $surveyId in the hvldata table already
        // Should come up with a better way of doing this
        if (HVLData::where('survey_id', $surveyId)->where('tube_id', $tubeId)->get()->count() > 0) {
            $this->error('Fluoro data already exists for this survey. Terminating.');

            return false;
        }

        $this->info('Saving data for survey ID: '.$surveyId);

        // Store HVL to database
        $HVLData = new HVLData();
        $HVLData->survey_id = $survey->id;
        $HVLData->machine_id = $machine->id;
        $HVLData->tube_id = $tubeId;
        $HVLData->kv = (float) $dataPage->getCell('B3')->getCalculatedValue();
        $HVLData->hvl = (float) $dataPage->getCell('C3')->getCalculatedValue();
        $HVLData->save();
        $machineSurveyData->hvldata = 1;
        $this->info('HVL data saved.');

        // Get image receptor field sizes (cm)
        $fieldSizes[0] = $dataPage->getCell('B4')->getCalculatedValue();
        $fieldSizes[1] = $dataPage->getCell('B5')->getCalculatedValue();
        $fieldSizes[2] = $dataPage->getCell('B6')->getCalculatedValue();
        $fieldSizes[3] = $dataPage->getCell('B7')->getCalculatedValue();
        $fieldSizes[4] = $dataPage->getCell('B8')->getCalculatedValue();

        // Get dose modes
        $doseModes[0] = $dataPage->getCell('B9')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('B10')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('B11')->getCalculatedValue();

        // Get fluoro entrance exposure rate data
        $entranceExpRate = $dataPage->rangeToArray('B12:K26', null, true, false, false);
        $maxEntraceExpRate = $dataPage->rangeToArray('B27:K27', null, true, false, false);

        // Store entrance exposure rate data
        $j = 0;
        foreach ($fieldSizes as $fs) {
            if (empty($fs) || $fs == 0) {
                // Skip if field size is empty or 0
                continue;
            }

            for ($i = 0; $i <= 2; $i++) {
                $fluoroData = new FluoroData();
                $fluoroData->survey_id = $survey->id;
                $fluoroData->machine_id = $machine->id;
                $fluoroData->tube_id = $tubeId;
                $fluoroData->field_size = $fs;
                $fluoroData->atten = $entranceExpRate[$i][0];
                $fluoroData->dose1_mode = $doseModes[0];
                $fluoroData->dose1_kv = (float) round($entranceExpRate[$j + $i][1], 1);
                $fluoroData->dose1_ma = (float) round($entranceExpRate[$j + $i][2], 1);
                $fluoroData->dose1_rate = (float) round($entranceExpRate[$j + $i][3], 3);
                $fluoroData->dose2_mode = $doseModes[1];
                $fluoroData->dose2_kv = (float) round($entranceExpRate[$j + $i][4], 1);
                $fluoroData->dose2_ma = (float) round($entranceExpRate[$j + $i][5], 1);
                $fluoroData->dose2_rate = (float) round($entranceExpRate[$j + $i][6], 3);
                $fluoroData->dose3_mode = $doseModes[2];
                $fluoroData->dose3_kv = (float) round($entranceExpRate[$j + $i][7], 1);
                $fluoroData->dose3_ma = (float) round($entranceExpRate[$j + $i][8], 1);
                $fluoroData->dose3_rate = (float) round($entranceExpRate[$j + $i][9], 3);
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
        $max->dose1_kv = (float) round($maxEntraceExpRate[0][0], 1);
        $max->dose1_ma = (float) round($maxEntraceExpRate[0][1], 1);
        $max->dose1_rate = (float) round($maxEntraceExpRate[0][2], 3);
        $max->dose2_kv = (float) round($maxEntraceExpRate[0][3], 1);
        $max->dose2_ma = (float) round($maxEntraceExpRate[0][4], 1);
        $max->dose2_rate = (float) round($maxEntraceExpRate[0][5], 3);
        $max->dose3_kv = (float) round($maxEntraceExpRate[0][6], 1);
        $max->dose3_ma = (float) round($maxEntraceExpRate[0][7], 1);
        $max->dose3_rate = (float) round($maxEntraceExpRate[0][8], 3);
        $max->save();
        $machineSurveyData->maxfluorodata = 1;
        $this->info('Max fluoro entrance exposure rates saved.');

        // Get receptor entrance exposure rate data
        $receptorEntrExpRate = $dataPage->rangeToArray('B47:F61', null, true, false, false);
        foreach ($receptorEntrExpRate as $k => $r) {
            // Skip the record if it's empty
            if (empty($r[0])) {
                continue;
            }
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
        $doseModes[0] = $dataPage->getCell('B28')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('B29')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('B30')->getCalculatedValue();
        $entranceExpRate = $dataPage->rangeToArray('B31:K45', null, true, false, false);
        $maxEntraceExpRate = $dataPage->rangeToArray('B46:K46', null, true, false, false);

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
                $fluoroData->dose1_kv = (float) round($entranceExpRate[$j + $i][1], 1);
                $fluoroData->dose1_ma = (float) round($entranceExpRate[$j + $i][2], 1);
                $fluoroData->dose1_rate = (float) round($entranceExpRate[$j + $i][3], 3);
                $fluoroData->dose2_mode = $doseModes[1];
                $fluoroData->dose2_kv = (float) round($entranceExpRate[$j + $i][4], 1);
                $fluoroData->dose2_ma = (float) round($entranceExpRate[$j + $i][5], 1);
                $fluoroData->dose2_rate = (float) round($entranceExpRate[$j + $i][6], 3);
                $fluoroData->dose3_mode = $doseModes[2];
                $fluoroData->dose3_kv = (float) round($entranceExpRate[$j + $i][7], 1);
                $fluoroData->dose3_ma = (float) round($entranceExpRate[$j + $i][8], 1);
                $fluoroData->dose3_rate = (float) round($entranceExpRate[$j + $i][9], 3);
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
        $max->dose1_kv = (float) round($maxEntraceExpRate[0][0], 1);
        $max->dose1_ma = (float) round($maxEntraceExpRate[0][1], 1);
        $max->dose1_rate = (float) round($maxEntraceExpRate[0][2], 3);
        $max->dose2_kv = (float) round($maxEntraceExpRate[0][3], 1);
        $max->dose2_ma = (float) round($maxEntraceExpRate[0][4], 1);
        $max->dose2_rate = (float) round($maxEntraceExpRate[0][5], 3);
        $max->dose3_kv = (float) round($maxEntraceExpRate[0][6], 1);
        $max->dose3_ma = (float) round($maxEntraceExpRate[0][7], 1);
        $max->dose3_rate = (float) round($maxEntraceExpRate[0][8], 3);
        $max->save();
        $this->info('Max pulse/digital entrance exposure rates saved.');

        // Get pulse/digital entrance exposure rate data
        $receptorEntrExpRate = $dataPage->rangeToArray('B62:F76', null, true, false, false);
        foreach ($receptorEntrExpRate as $k => $r) {
            // Skip the record if it's empty
            if (empty($r[0])) {
                continue;
            }
            $ree = new ReceptorEntranceExp();
            $ree->survey_id = $survey->id;
            $ree->machine_id = $machine->id;
            $ree->tube_id = $tubeId;
            $ree->field_size = $r[0];
            $ree->mode = $doseModes[floor($k / 5)];
            $ree->kv = (float) $r[1];
            $ree->ma = (float) $r[2];
            $ree->rate = (float) $r[4];
            $ree->save();
        }
        $machineSurveyData->receptorentrance = 1;
        $this->info('Pulse/digital receptor entrance exposure rates stored.');

        // Process data for Leeds test objects
        // Leeds TO.N3
        // Column B - field size
        // Column C - N3 low contrast resolution
        $to_n3 = $dataPage->rangeToArray('B77:C81', null, true, false, false);
        foreach ($to_n3 as $k=>$r) {
            // Skip the record if it's empty
            if (empty($r[0])) {
                continue;
            }
            $n3 = new LeedsN3();
            $n3->survey_id = $survey->id;
            $n3->machine_id = $machine->id;
            $n3->tube_id = $tubeId;
            $n3->field_size = $r[0];
            $n3->n3 = (float) $r[1];
            $n3->save();
        }
        $machineSurveyData->leeds_n3 = 1;
        $this->info('Leeds N3 stored');

        // Leeds TO.10 CD
        // Col B - field size.
        // Rows 83-87 - Contrast detail.
        $to_10 = $dataPage->rangeToArray('B83:N87', null, true, false, false);
        foreach ($to_10 as $cd) {
            // Skip the record if it's empty
            if (empty($cd['B'])) {
                continue;
            }
            $to10_cd = new LeedsTO10CD();
            $to10_cd->survey_id = $survey->id;
            $to10_cd->machine_id = $machine->id;
            $to10_cd->tube_id = $tubeId;
            $to10_cd->field_size = $cd['B'];
            $to10_cd->A = empty($cd['C']) ? null : (float) $cd['C'];
            $to10_cd->B = empty($cd['D']) ? null : (float) $cd['D'];
            $to10_cd->C = empty($cd['E']) ? null : (float) $cd['E'];
            $to10_cd->D = empty($cd['F']) ? null : (float) $cd['F'];
            $to10_cd->E = empty($cd['G']) ? null : (float) $cd['G'];
            $to10_cd->F = empty($cd['H']) ? null : (float) $cd['H'];
            $to10_cd->G = empty($cd['I']) ? null : (float) $cd['I'];
            $to10_cd->H = empty($cd['J']) ? null : (float) $cd['J'];
            $to10_cd->J = empty($cd['K']) ? null : (float) $cd['K'];
            $to10_cd->K = empty($cd['L']) ? null : (float) $cd['L'];
            $to10_cd->L = empty($cd['M']) ? null : (float) $cd['M'];
            $to10_cd->M = empty($cd['N']) ? null : (float) $cd['N'];
            $to10_cd->save();
        }
        // Rows 88-92 - Threshold index.
        $to_10 = $dataPage->rangeToArray('B88:N92', null, true, false, false);
        foreach ($to_10 as $ti) {
            // Skip the record if it's empty
            if (empty($ti['B'])) {
                continue;
            }
            $to10_ti = new LeedsTO10TI();
            $to10_ti->survey_id = $survey->id;
            $to10_ti->machine_id = $machine->id;
            $to10_ti->tube_id = $tubeId;
            $to10_ti->field_size = $ti['B'];
            $to10_ti->A = empty($ti['C']) ? null : (float) $ti['C'];
            $to10_ti->B = empty($ti['D']) ? null : (float) $ti['D'];
            $to10_ti->C = empty($ti['E']) ? null : (float) $ti['E'];
            $to10_ti->D = empty($ti['F']) ? null : (float) $ti['F'];
            $to10_ti->E = empty($ti['G']) ? null : (float) $ti['G'];
            $to10_ti->F = empty($ti['H']) ? null : (float) $ti['H'];
            $to10_ti->G = empty($ti['I']) ? null : (float) $ti['I'];
            $to10_ti->H = empty($ti['J']) ? null : (float) $ti['J'];
            $to10_ti->J = empty($ti['K']) ? null : (float) $ti['K'];
            $to10_ti->K = empty($ti['L']) ? null : (float) $ti['L'];
            $to10_ti->L = empty($ti['M']) ? null : (float) $ti['M'];
            $to10_ti->M = empty($ti['N']) ? null : (float) $ti['N'];
            $to10_ti->save();
        }
        $machineSurveyData->leeds_to10 = 1;

        // Resolution
        // Col B - Field size
        // Col C - Resolution (lp/mm)
        $res = $dataPage->rangeToArray('B93:C97', null, true, false, false);
        foreach ($res as $k=>$r) {
            // Skip the record if it's empty
            if (empty($r[0])) {
                continue;
            }
            $fluoroRes = new FluoroResolution();
            $fluoroRes->survey_id = $survey->id;
            $fluoroRes->machine_id = $machine->id;
            $fluoroRes->tube_id = $tubeId;
            $fluoroRes->field_size = $r[0];
            $fluoroRes->resolution = (float) $r[1];
            $fluoroRes->save();
        }
        $machineSurveyData->fluoro_resolution = 1;

        $machineSurveyData->save();

        return true;
    }

    /**
     * Import mammography (Hologic) spreadsheet data.
     *
     * @param int $surveyId
     * @param \PhpOffice\PhpSpreadsheet\Reader $dataPage
     * @return bool
     */
    private function importMammoHol($surveyId, $dataPage)
    {
    }

    /**
     * Import mammography (Siemens) spreadsheet data.
     *
     * @param int $surveyId
     * @param \PhpOffice\PhpSpreadsheet\Reader $dataPage
     * @return bool
     */
    private function importMammoSie($surveyId, $dataPage)
    {
    }

    /**
     * Import SBB spreadsheet data.
     *
     * @param int $surveyId
     * @param \PhpOffice\PhpSpreadsheet\Reader $dataPage
     * @return bool
     */
    private function importSbb($surveyId, $dataPage)
    {
    }
}
