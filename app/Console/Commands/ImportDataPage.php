<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Ods;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use RadDB\CollimatorData;
use RadDB\FluoroData;
use RadDB\FluoroResolution;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\LeedsN3;
use RadDB\LeedsTO10CD;
use RadDB\LeedsTO10TI;
use RadDB\MachineSurveyData;
use RadDB\MamAcrPhantom;
use RadDB\MamHvl;
use RadDB\MamKvOutput;
use RadDB\MamLinearity;
use RadDB\MamResolution;
use RadDB\MamSurveyData;
use RadDB\MaxFluoroData;
use RadDB\RadiationOutput;
use RadDB\RadSurveyData;
use RadDB\ReceptorEntranceExp;
use RadDB\TestDate;
use RadDB\Tube;

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
     * Array for survey data that will be passed to the methods importing data.
     *
     * @var array
     */
    protected $surveyData = [
        'surveyId' => '',
        'machineId' => '',
        'tubeId' => '',
    ];

    /**
     * Bit flag for exposure linearity data.
     *
     * @var int
     */
    const LINEARITY = 0b0001;

    /**
     * Bit flag for kV accuracy.
     * @var int
     */
    const ACCURACY = 0b0010;

    /**
     * Bit flag for measurements used in HVL calculation.
     * @var int
     */
    const BEAMQUAL = 0b0100;

    /**
     * Bit flag for reproducibility.
     * @var int
     */
    const REPRO = 0b1000;

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
        [$file, $ext] = explode('.', $spreadsheetFile);

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

        // Figure out what type of spreadsheet has been loaded
        $sheetType = $dataPage->getCell('B1')->getCalculatedValue();

        // Get the survey data for this spreadsheet
        $this->surveyData['surveyId'] = $dataPage->getCell('B2')->getCalculatedValue();
        $survey = TestDate::find($this->surveyData['surveyId']);
        $this->surveyData['machineId'] = $survey->machine_id;
        $this->surveyData['tubeId'] = $this->askTubeId($survey->machine_id);

        switch ($sheetType) {
            case 'RAD':
                $this->info('Processing '.$sheetType.' spreadsheet');
                $status = $this->importRad($spreadsheet);
                break;
            case 'FLUORO':
                $this->info('Processing '.$sheetType.' spreadsheet');
                $status = $this->importFluoro($spreadsheet);
                break;
            case 'MAMMO_HOL':
                $this->info('Processing '.$sheetType.' spreadsheet');
                $status = $this->importMammoHol($spreadsheet);
                break;
            case 'MAMMO_SIE':
                $this->info('Processing '.$sheetType.' spreadsheet');
                $status = $this->importMammoSie($spreadsheet);
                break;
            case 'SBB':
                $this->info('Processing '.$sheetType.' spreadsheet');
                $status = $this->importSbb($spreadsheet);
                break;
            default:
                $status = 0;
                $this->error('Not a compatible spreadsheet');
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

        if (is_null($tubes)) {
            // No tubes associated with this machine
            return;
        }

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
     * @param object $spreadsheet
     * @return bool
     */
    private function importRad($spreadsheet)
    {
        // Get the DataPage tab from the spreadsheet.
        $dataPage = $spreadsheet->getSheetByName('DataPage');

        // Check to see if any survey data has been entered for this survey ID
        $machineSurveyData = MachineSurveyData::find($this->surveyData['surveyId']);
        if (is_null($machineSurveyData)) {
            $machineSurveyData = new MachineSurveyData();
        }
        $machineSurveyData->id = $this->surveyData['surveyId'];
        $machineSurveyData->machine_id = $this->surveyData['machineId'];

        $this->info('Saving data for survey ID: '.$this->surveyData['surveyId']);

        // SID accuracy, illumination, centering, resolution, alignment
        if ($machineSurveyData->radsurveydata) {
            $this->info('Rad survey data exists already. Skipping.');
        } else {
            $radSurvey = new RadSurveyData();
            $radSurvey->survey_id = $this->surveyData['surveyId'];
            $radSurvey->machine_id = $this->surveyData['machineId'];
            $radSurvey->tube_id = $this->surveyData['tubeId'];
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
        }

        //Collimator data
        if ($machineSurveyData->collimatordata) {
            $this->info('Collimator data exists already. Skipping.');
        } else {
            // Table bucky SID (cm)
            $tableSid = $dataPage->getCell('B10')->getCalculatedValue();

            // Wall bucky SID (cm)
            $wallSid = $dataPage->getCell('B11')->getCalculatedValue();

            // Field size indicators, radiation/light field alignment for table bucky
            // First pair - Indicated field size (cm)
            // Second pair - Radiation field (cm)
            // Third pair - Light field (cm)
            $collimationTable = $dataPage->rangeToArray('B12:G13', null, true, false, false);

            // Automatic collimation (PBL) for table bucky
            // First pair - Cassette size (cm)
            $pblTable = $dataPage->rangeToArray('B14:C15', null, true, false, false);

            // Field size indicators, radiation/light field alignment for wall bucky
            // First pair - Indicated field size (cm)
            // Second pair - Radiation field (cm)
            // Third pair - Light field (cm)
            $collimationWall = $dataPage->rangeToArray('B16:G17', null, true, false, false);

            // Automatic collimation (PBL) for wall bucky
            // First pair - Cassette size (cm)
            $pblWall = $dataPage->rangeToArray('B18:C19', null, true, false, false);

            // Insert the collimator data into the database
            // Table receptor
            for ($i = 0; $i <= 1; $i++) {
                $collimatorData = new CollimatorData();
                $collimatorData->survey_id = $this->surveyData['surveyId'];
                $collimatorData->machine_id = $this->surveyData['machineId'];
                $collimatorData->tube_id = $this->surveyData['tubeId'];
                $collimatorData->sid = $tableSid;
                $collimatorData->receptor = 'Table';
                $collimatorData->indicated_trans = $collimationTable[$i][0] == 'NA' ? null : (float) $collimationTable[$i][0];
                $collimatorData->indicated_long = $collimationTable[$i][1] == 'NA' ? null : (float) $collimationTable[$i][1];
                $collimatorData->rad_trans = $collimationTable[$i][2] == 'NA' ? null : (float) $collimationTable[$i][2];
                $collimatorData->rad_long = $collimationTable[$i][3] == 'NA' ? null : (float) $collimationTable[$i][3];
                $collimatorData->light_trans = $collimationTable[$i][4] == 'NA' ? null : (float) $collimationTable[$i][4];
                $collimatorData->light_long = $collimationTable[$i][5] == 'NA' ? null : (float) $collimationTable[$i][5];
                $collimatorData->pbl_cass_trans = $pblTable[$i][0] == 'NA' ? null : (float) $pblTable[$i][0];
                $collimatorData->pbl_cass_long = $pblTable[$i][1] == 'NA' ? null : (float) $pblTable[$i][1];
                $collimatorData->save();
            }
            $this->info('Table receptor collimator data saved');

            // Wall receptor
            for ($i = 0; $i <= 1; $i++) {
                $collimatorData = new CollimatorData();
                $collimatorData->survey_id = $this->surveyData['surveyId'];
                $collimatorData->machine_id = $this->surveyData['machineId'];
                $collimatorData->tube_id = $this->surveyData['tubeId'];
                $collimatorData->sid = $wallSid;
                $collimatorData->receptor = 'Wall';
                $collimatorData->indicated_trans = $collimationWall[$i][0] == 'NA' ? null : (float) $collimationWall[$i][0];
                $collimatorData->indicated_long = $collimationWall[$i][1] == 'NA' ? null : (float) $collimationWall[$i][1];
                $collimatorData->rad_trans = $collimationWall[$i][2] == 'NA' ? null : (float) $collimationWall[$i][2];
                $collimatorData->rad_long = $collimationWall[$i][3] == 'NA' ? null : (float) $collimationWall[$i][3];
                $collimatorData->light_trans = $collimationWall[$i][4] == 'NA' ? null : (float) $collimationWall[$i][4];
                $collimatorData->light_long = $collimationWall[$i][5] == 'NA' ? null : (float) $collimationWall[$i][5];
                $collimatorData->pbl_cass_trans = $pblWall[$i][0] == 'NA' ? null : (float) $pblWall[$i][0];
                $collimatorData->pbl_cass_long = $pblWall[$i][1] == 'NA' ? null : (float) $pblWall[$i][1];
                $collimatorData->save();
            }
            $machineSurveyData->collimatordata = 1;
            $this->info('Wall receptor collimator data saved');
        }

        if ($machineSurveyData->radoutputdata) {
            $this->info('Radiation output data exists already. Skipping.');
        } else {
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
                $radOutput->survey_id = $this->surveyData['surveyId'];
                $radOutput->machine_id = $this->surveyData['machineId'];
                $radOutput->tube_id = $this->surveyData['tubeId'];
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
                $radOutput->survey_id = $this->surveyData['surveyId'];
                $radOutput->machine_id = $this->surveyData['machineId'];
                $radOutput->tube_id = $this->surveyData['tubeId'];
                $radOutput->focus = 'Small';
                $radOutput->kv = (float) $s[0];
                $radOutput->output = (float) $s[1];
                $radOutput->save();
            }
            $machineSurveyData->radoutputdata = 1;
            $this->info('Small focus output data saved.');
        }

        // Load generator test data from cells AA688:BB747 into an array
        if ($machineSurveyData->gendata) {
            $this->info('Generator data exists already. Skipping.');
        } else {
            $genTestData = $dataPage->rangeToArray('B34:AC93', null, true, false, true);

            // Insert generator test data into the database
            foreach ($genTestData as $genDataRow) {
                // Skip the record if it's empty
                if (empty($genDataRow['AA'])) {
                    continue;
                }

                $genData = new GenData();
                $genData->survey_id = $this->surveyData['surveyId'];
                $genData->machine_id = $this->surveyData['machineId'];
                $genData->tube_id = $this->surveyData['tubeId'];
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
                $genData->kv_avg = empty($genDataRow['Y']) ? null : (float) $genDataRow['Y'];
                $genData->kv_max = empty($genDataRow['Z']) ? null : (float) $genDataRow['Z'];
                $genData->kv_eff = empty($genDataRow['AA']) ? null : (float) $genDataRow['AA'];
                $genData->exp_time = empty($genDataRow['AB']) ? null : (float) $genDataRow['AB'];
                $genData->exposure = empty($genDataRow['AC']) ? null : (float) $genDataRow['AC'];

                // Store the data
                $genData->save();
            }
            $machineSurveyData->gendata = 1;
            $this->info('Generator test data saved.');
        }

        // Get half value layer data
        // kV, HVL (mm Al)
        if ($machineSurveyData->hvldata) {
            $this->info('HVL data exists already. Skipping.');
        } else {
            $hvls = $dataPage->rangeToArray('B94:C103', null, true, false, false);

            // Insert the HVL data into the database
            foreach ($hvls as $hvl) {
                $HVLData = new HVLData();
                $HVLData->survey_id = $this->surveyData['surveyId'];
                $HVLData->machine_id = $this->surveyData['machineId'];
                $HVLData->tube_id = $this->surveyData['tubeId'];
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
        }

        return 1;
    }

    /**
     * Import fluoroscopy spreadsheet data.
     *
     * @param object $spreadsheet
     * @return bool
     */
    private function importFluoro($spreadsheet)
    {
        // Get the DataPage tab from the spreadsheet.
        $dataPage = $spreadsheet->getSheetByName('DataPage');

        // Check to see if any survey data has been entered for this survey ID
        $machineSurveyData = MachineSurveyData::find($this->surveyData['surveyId']);
        if (is_null($machineSurveyData)) {
            $machineSurveyData = new MachineSurveyData();
        }

        $machineSurveyData->id = $this->surveyData['surveyId'];
        $machineSurveyData->machine_id = $this->surveyData['machineId'];

        $this->surveyData['tubeId'] = $this->askTubeId($this->surveyData['machineId']);

        $this->info('Saving data for survey ID: '.$this->surveyData['surveyId']);

        // Store HVL to database
        if ($machineSurveyData->hvldata) {
            $this->info('HVL data exists already. Skipping.');
        } else {
            $HVLData = new HVLData();
            $HVLData->survey_id = $this->surveyData['surveyId'];
            $HVLData->machine_id = $this->surveyData['machineId'];
            $HVLData->tube_id = $this->surveyData['tubeId'];
            $HVLData->kv = (float) $dataPage->getCell('B3')->getCalculatedValue();
            $HVLData->hvl = (float) $dataPage->getCell('C3')->getCalculatedValue();
            // $HVLData->save();
            $machineSurveyData->hvldata = 1;
            $this->info('HVL data saved.');
        }

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
        if ($machineSurveyData->fluorodata_1) {
            $this->info('Fluoro SEE data exists already. Skipping.');
        } else {
            $j = 0;
            foreach ($fieldSizes as $fs) {
                if (empty($fs) || $fs == 0) {
                    // Skip if field size is empty or 0
                    continue;
                }
                for ($i = 0; $i <= 2; $i++) {
                    $fluoroData = new FluoroData();
                    $fluoroData->survey_id = $this->surveyData['surveyId'];
                    $fluoroData->machine_id = $this->surveyData['machineId'];
                    $fluoroData->tube_id = $this->surveyData['tubeId'];
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
                    // $fluoroData->save();
                }
                $j += 3;
            }
            $machineSurveyData->fluorodata_1 = 1;
            $this->info('Fluoro entrance exposure rates saved.');
        }

        // Store max entrance exposure rates
        if ($machineSurveyData->maxfluorodata_1) {
            $this->info('Max SEE already exists. Skipping.');
        } else {
            $max = new MaxFluoroData();
            $max->survey_id = $this->surveyData['surveyId'];
            $max->machine_id = $this->surveyData['machineId'];
            $max->tube_id = $this->surveyData['tubeId'];
            $max->dose1_kv = (float) round($maxEntraceExpRate[0][0], 1);
            $max->dose1_ma = (float) round($maxEntraceExpRate[0][1], 1);
            $max->dose1_rate = (float) round($maxEntraceExpRate[0][2], 3);
            $max->dose2_kv = (float) round($maxEntraceExpRate[0][3], 1);
            $max->dose2_ma = (float) round($maxEntraceExpRate[0][4], 1);
            $max->dose2_rate = (float) round($maxEntraceExpRate[0][5], 3);
            $max->dose3_kv = (float) round($maxEntraceExpRate[0][6], 1);
            $max->dose3_ma = (float) round($maxEntraceExpRate[0][7], 1);
            $max->dose3_rate = (float) round($maxEntraceExpRate[0][8], 3);
            // $max->save();
            $machineSurveyData->maxfluorodata_1 = 1;
            $this->info('Max fluoro entrance exposure rates saved.');
        }

        // Get receptor entrance exposure rate data
        if ($machineSurveyData->receptorentrance_1) {
            $this->info('Receptor entrance exposure data already exists. Skipping');
        } else {
            $receptorEntrExpRate = $dataPage->rangeToArray('B47:F61', null, true, false, false);
            foreach ($receptorEntrExpRate as $k => $r) {
                // Skip the record if it's empty
                if (empty($r[0])) {
                    continue;
                }
                $ree = new ReceptorEntranceExp();
                $ree->survey_id = $this->surveyData['surveyId'];
                $ree->machine_id = $this->surveyData['machineId'];
                $ree->tube_id = $this->surveyData['tubeId'];
                $ree->field_size = $r[0];
                $ree->mode = $doseModes[floor($k / 5)];
                $ree->kv = $r[1];
                $ree->ma = $r[2];
                $ree->rate = $r[4];
                // $ree->save();
                $machineSurveyData->receptorentrance_1 = 1;
                $this->info('Fluoro recepter entrance exposure rates stored.');
            }
        }

        // Get pulse/digital entrance exposure rate data
        $doseModes[0] = $dataPage->getCell('B28')->getCalculatedValue();
        $doseModes[1] = $dataPage->getCell('B29')->getCalculatedValue();
        $doseModes[2] = $dataPage->getCell('B30')->getCalculatedValue();
        $entranceExpRate = $dataPage->rangeToArray('B31:K45', null, true, false, false);
        $maxEntraceExpRate = $dataPage->rangeToArray('B46:K46', null, true, false, false);

        // Store pulse/digital entrance exposure rate data
        if ($machineSurveyData->fluorodata_2) {
            $this->info('Pulse/digital SEE data already exists. Skipping.');
        } else {
            $j = 0;
            foreach ($fieldSizes as $fs) {
                for ($i = 0; $i <= 2; $i++) {
                    $fluoroData = new FluoroData();
                    $fluoroData->survey_id = $this->surveyData['surveyId'];
                    $fluoroData->machine_id = $this->surveyData['machineId'];
                    $fluoroData->tube_id = $this->surveyData['tubeId'];
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
                    // $fluoroData->save();
                }
                $j += 3;
            }
            $machineSurveyData->fluorodata_2 = 1;
            $this->info('Pulse/digital entrance exposure rates saved.');
        }

        // Store pulse/digital max entrance exposure rates
        if ($machineSurveyData->maxfluorodata_1) {
            $this->info('Max SEE already exists. Skipping.');
        } else {
            $max = new MaxFluoroData();
            $max->survey_id = $this->surveyData['surveyId'];
            $max->machine_id = $this->surveyData['machineId'];
            $max->tube_id = $this->surveyData['tubeId'];
            $max->dose1_kv = (float) round($maxEntraceExpRate[0][0], 1);
            $max->dose1_ma = (float) round($maxEntraceExpRate[0][1], 1);
            $max->dose1_rate = (float) round($maxEntraceExpRate[0][2], 3);
            $max->dose2_kv = (float) round($maxEntraceExpRate[0][3], 1);
            $max->dose2_ma = (float) round($maxEntraceExpRate[0][4], 1);
            $max->dose2_rate = (float) round($maxEntraceExpRate[0][5], 3);
            $max->dose3_kv = (float) round($maxEntraceExpRate[0][6], 1);
            $max->dose3_ma = (float) round($maxEntraceExpRate[0][7], 1);
            $max->dose3_rate = (float) round($maxEntraceExpRate[0][8], 3);
            // $max->save();
            $machineSurveyData->maxfluorodata_2 = 1;
            $this->info('Max pulse/digital entrance exposure rates saved.');
        }

        // Get pulse/digital entrance exposure rate data
        if ($machineSurveyData->receptorentrance_2) {
            $this->info('Receptor entrance exposure data already exists. Skipping');
        } else {
            $receptorEntrExpRate = $dataPage->rangeToArray('B62:F76', null, true, false, false);
            foreach ($receptorEntrExpRate as $k => $r) {
                // Skip the record if it's empty
                if (empty($r[0])) {
                    continue;
                }
                $ree = new ReceptorEntranceExp();
                $ree->survey_id = $this->surveyData['surveyId'];
                $ree->machine_id = $this->surveyData['machineId'];
                $ree->tube_id = $this->surveyData['tubeId'];
                $ree->field_size = $r[0];
                $ree->mode = $doseModes[floor($k / 5)];
                $ree->kv = (float) $r[1];
                $ree->ma = (float) $r[2];
                $ree->rate = (float) $r[4];
                // $ree->save();
            }
            $machineSurveyData->receptorentrance_2 = 1;
            $this->info('Pulse/digital receptor entrance exposure rates stored.');
        }

        // Process data for Leeds test objects
        // Leeds TO.N3
        // Column B - field size
        // Column C - N3 low contrast resolution
        if ($machineSurveyData->leeds_n3) {
            $this->info('Leeds N3 data exists already. Skipping');
        } else {
            $to_n3 = $dataPage->rangeToArray('B77:C81', null, true, false, true);
            foreach ($to_n3 as $k=>$r) {
                // Skip the record if it's empty
                if (empty($r[0])) {
                    continue;
                }
                $n3 = new LeedsN3();
                $n3->survey_id = $this->surveyData['surveyId'];
                $n3->machine_id = $this->surveyData['machineId'];
                $n3->tube_id = $this->surveyData['tubeId'];
                $n3->field_size = $r[0];
                $n3->n3 = (float) $r[1];
                // $n3->save();
            }
            $machineSurveyData->leeds_n3 = 1;
            $this->info('Leeds N3 stored');
        }

        // Leeds TO.10 CD
        // Col B - field size.
        // Rows 83-87 - Contrast detail.
        if ($machineSurveyData->leeds_to10) {
            $this->info('Leeds TO.10 data exists. Skipping');
        } else {
            $to_10 = $dataPage->rangeToArray('B83:N87', null, true, false, true);
            foreach ($to_10 as $cd) {
                // Skip the record if it's empty
                if (empty($cd['B'])) {
                    continue;
                }
                $to10_cd = new LeedsTO10CD();
                $to10_cd->survey_id = $this->surveyData['surveyId'];
                $to10_cd->machine_id = $this->surveyData['machineId'];
                $to10_cd->tube_id = $this->surveyData['tubeId'];
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
                // $to10_cd->save();
            }
            // Rows 88-92 - Threshold index.
            $to_10 = $dataPage->rangeToArray('B88:N92', null, true, false, false);
            foreach ($to_10 as $ti) {
                // Skip the record if it's empty
                if (empty($ti['B'])) {
                    continue;
                }
                $to10_ti = new LeedsTO10TI();
                $to10_ti->survey_id = $this->surveyData['surveyId'];
                $to10_ti->machine_id = $this->surveyData['machineId'];
                $to10_ti->tube_id = $this->surveyData['tubeId'];
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
                // $to10_ti->save();
            }
            $machineSurveyData->leeds_to10 = 1;
            $this->info('Leeds TO.10 stored');
        }

        // Resolution
        // Col B - Field size
        // Col C - Resolution (lp/mm)
        if ($machineSurveyData->fluoro_resolution) {
            $this->info('Fluoro resolution data exists. Skipping.');
        } else {
            $res = $dataPage->rangeToArray('B93:C97', null, true, false, false);
            foreach ($res as $k=>$r) {
                // Skip the record if it's empty
                if (empty($r[0])) {
                    continue;
                }
                $fluoroRes = new FluoroResolution();
                $fluoroRes->survey_id = $this->surveyData['surveyId'];
                $fluoroRes->machine_id = $this->surveyData['machineId'];
                $fluoroRes->tube_id = $this->surveyData['tubeId'];
                $fluoroRes->field_size = $r[0];
                $fluoroRes->resolution = (float) $r[1];
                // $fluoroRes->save();
            }
            $machineSurveyData->fluoro_resolution = 1;
            $this->info('Fluoro resolution stored');
        }

        // $machineSurveyData->save();

        return 1;
    }

    /**
     * Import mammography (Hologic) spreadsheet data.
     *
     * @param object $spreadsheet
     * @return bool
     */
    private function importMammoHol($spreadsheet)
    {
        // Get the DataPage tab from the spreadsheet.
        $dataPage = $spreadsheet->getSheetByName('DataPage');

        // Check to see if any survey data has been entered for this survey ID
        $machineSurveyData = MachineSurveyData::find($this->surveyData['surveyId']);
        if (is_null($machineSurveyData)) {
            $machineSurveyData = new MachineSurveyData();
        }

        $machineSurveyData->id = $this->surveyData['surveyId'];
        $machineSurveyData->machine_id = $this->surveyData['machineId'];

        $this->surveyData['tubeId'] = $this->askTubeId($this->surveyData['machineId']);

        $this->info('Saving data for survey ID: '.$this->surveyData['surveyId']);

        // Get survey data
        // Light field, MGD, CNR/SNR
        if ($machineSurveyData->mamsurveydata) {
            $this->info('Mammo light field, MGD and CNR/SNR data exists already. Skipping.');
        } else {
            $lightField = $dataPage->getCell('B3')->getCalculatedValue();
            $mgd_2d = $dataPage->getCell('B7')->getCalculatedValue();
            $mgd_3d = $dataPage->getCell('B8')->getCalculatedValue();
            $mgd_combo = $dataPage->getCell('B9')->getCalculatedValue();
            $snr = $dataPage->getCell('B41')->getCalculatedValue();
            $cnr = $dataPage->getCell('B42')->getCalculatedValue();

            $mamSurveyData = new MamSurveyData();
            $mamSurveyData->survey_id = $this->surveyData['surveyId'];
            $mamSurveyData->machine_id = $this->surveyData['machineId'];
            $mamSurveyData->tube_id = $this->surveyData['tubeId'];
            $mamSurveyData->avg_illumination = empty($lightField) ? null : $lightField;
            $mamSurveyData->mgd_2d = empty($mgd_2d) ? null : $mgd_2d;
            $mamSurveyData->mgd_3d = $mgd_3d == 'NA' ? null : $mgd_3d;
            $mamSurveyData->mgd_combo = $mgd_combo == 'NA' ? null : $mgd_combo;
            $mamSurveyData->snr = empty($snr) ? null : $snr;
            $mamSurveyData->cnr = empty($cnr) ? null : $cnr;
        }

        // Get resolution data
        if ($machineSurveyData->mamresolution) {
            $this->info('Mammo resolution data exists already. Skipping');
        } else {
        }

        // Get half value layer data
        // kV, HVL (mm Al)
        if ($machineSurveyData->hvldata) {
            $this->info('Mammo HVL data exists already. Skipping.');
        } else {
            $hvls = $dataPage->rangeToArray('B23:D35', null, true, false, false);

            // Insert the HVL data into the database
            foreach ($hvls as $hvl) {
                $HVLData = new HVLData();
                $HVLData->survey_id = $this->surveyData['surveyId'];
                $HVLData->machine_id = $this->surveyData['machineId'];
                $HVLData->tube_id = $this->surveyData['tubeId'];
                if (empty($hvl[1]) || empty($hvl[2])) {
                    // Skip the record if it's empty
                    continue;
                }
                $HVLData->kv = (float) $hvl[1];
                $HVLData->hvl = (float) $hvl[2];
                $HVLData->save();
            }
            $machineSurveyData->hvldata = 1;
            $this->info('HVL data saved.');

            $machineSurveyData->save();
        }

        return 1;
    }

    /**
     * Import mammography (Siemens) spreadsheet data.
     *
     * @param object $spreadsheet
     * @return bool
     */
    private function importMammoSie($spreadsheet)
    {
        // Get the DataPage tab from the spreadsheet.
        $dataPage = $spreadsheet->getSheetByName('DataPage');

        // Check to see if any survey data has been entered for this survey ID
        $machineSurveyData = MachineSurveyData::find($this->surveyData['surveyId']);
        if (is_null($machineSurveyData)) {
            $machineSurveyData = new MachineSurveyData();
        }

        $machineSurveyData->id = $this->surveyData['surveyId'];
        $machineSurveyData->machine_id = $this->surveyData['machineId'];

        $this->surveyData['tubeId'] = $this->askTubeId($this->surveyData['machineId']);

        $this->info('Saving data for survey ID: '.$this->surveyData['surveyId']);

        return 1;
    }

    /**
     * Import SBB spreadsheet data.
     *
     * @param object $spreadsheet
     * @return bool
     */
    private function importSbb($spreadsheet)
    {
        // Get the DataPage tab from the spreadsheet.
        $dataPage = $spreadsheet->getSheetByName('DataPage');

        // Check to see if any survey data has been entered for this survey ID
        $machineSurveyData = MachineSurveyData::find($this->surveyData['surveyId']);
        if (is_null($machineSurveyData)) {
            $machineSurveyData = new MachineSurveyData();
        }

        $machineSurveyData->id = $this->surveyData['surveyId'];
        $machineSurveyData->machine_id = $this->surveyData['machineId'];

        $this->surveyData['tubeId'] = $this->askTubeId($this->surveyData['machineId']);

        $this->info('Saving data for survey ID: '.$this->surveyData['surveyId']);

        return 1;
    }
}
