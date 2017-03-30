<?php

namespace RadDB\Console\Commands;

use PHPExcel;
use RadDB\Tube;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\Machine;
use RadDB\TestDate;
use RadDB\RadSurveyData;
use RadDB\CollimatorData;
use RadDB\RadiationOutput;
use Illuminate\Console\Command;

class ImportRadSpreadsheet extends Command
{
    /**
     * Bit flags used to indicate what each line of the generator test data is used for
     *
     * @var int
     */
    const LINEARITY = 0b0001;
    const ACCURACY = 0b0010;
    const BEAMQUAL = 0b0100;
    const REPRO = 0b1000;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rad {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from radiography spreadsheet';

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

        // Read the spreadsheet
        echo "Loading spreadsheet\n";
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $genFormSheet = $spreadsheet->getSheetByName('Gen_form');
        echo "Spreadsheet loaded.\n";

        // Get the survey ID
        $surveyId = (int) $genFormSheet->getCell('E14')->getCalculatedValue();

        echo 'Saving data for survey ID: '.$surveyId."\n";
        // Pull info for this spreadsheet from the database
        $survey = TestDate::find(1938);
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

        // SID Indicator accuracy error.
        $sidAccuracyError = $genFormSheet->getCell('G484')->getCalculatedValue();
        // Average illumination in lux.
        $avgIllumination = $genFormSheet->getCell('I504')->getCalculatedValue();
        // Beam alignment error.
        $beamAlignmentErr = $genFormSheet->getCell('G537')->getCalculatedValue();
        // Radiation/film center distance (cm) for table bucky.
        $radFilmCenterTable = $genFormSheet->getCell('C547')->getCalculatedValue();
        // Radiation/film center distance (cm) for wall bucky.
        $radFilmCenterWall = $genFormSheet->getCell('C608')->getCalculatedValue();
        // Large/small focal spot resolution (lp/mm)
        $lfsResolution = $genFormSheet->getCell('I672')->getCalculatedValue();
        $sfsResolution = $genFormSheet->getCell('I677')->getCalculatedValue();
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
        echo "Radiographic survey data saved.\n";

        // Table bucky SID (cm)
        $tableSid = $genFormSheet->getCell('K543')->getCalculatedValue();
        // Wall bucky SID (cm)
        $wallSid = $genFormSheet->getCell('C615')->getCalculatedValue();
        // Field size indicators, radiation/light field alignment for table bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationTable = $genFormSheet->rangeToArray('B554:G555', null, true, false, false);
        // Automatic collimation (PBL) for table bucky
        // First pair - Cassette size (cm)
        $pblTable = $genFormSheet->rangeToArray('B575:C576', null, true, false, false);
        // Field size indicators, radiation/light field alignment for wall bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationWall = $genFormSheet->rangeToArray('D615:I616', null, true, false, false);
        // Automatic collimation (PBL) for wall bucky
        // First pair - Cassette size (cm)
        $pblWall = $genFormSheet->rangeToArray('C637:D638', null, true, false, false);
        // Insert the collimator data into the database
        // Table receptor
        for ($i=0;$i<=1; $i++) {
            $collimatorData = new CollimatorData();
            $collimatorData->survey_id = $survey->id;
            $collimatorData->machine_id = $machine->id;
            $collimatorData->tube_id = $tubeId;
            $collimatorData->sid = $tableSid;
            $collimatorData->receptor = 'Table';
            $collimatorData->indicated_trans = $collimationTable[$i][0] == 'NA'? null : (float) $collimationTable[$i][0];
            $collimatorData->indicated_long = $collimationTable[$i][1] == 'NA' ? null : (float) $collimationTable[$i][1];
            $collimatorData->rad_trans = $collimationTable[$i][2] == 'NA' ? null : (float) $collimationTable[$i][2];
            $collimatorData->rad_long = $collimationTable[$i][3] == 'NA' ? null : (float) $collimationTable[$i][3];
            $collimatorData->light_trans = $collimationTable[$i][4] == 'NA' ? null : (float) $collimationTable[$i][4];
            $collimatorData->light_long = $collimationTable[$i][5] == 'NA' ? null : (float) $collimationTable[$i][5];
            $collimatorData->pbl_trans = $pblTable[$i][0] == 'NA' ? null : (float) $pblTable[$i][0];
            $collimatorData->pbl_long = $pblTable[$i][1] == 'NA' ? null : (float) $pblTable[$i][1];
            $collimatorData->save();
        }
        echo "Table receptor collimator data saved.\n";
        // Wall receptor
        for ($i=0;$i<=1; $i++) {
            $collimatorData = new CollimatorData();
            $collimatorData->survey_id = $survey->id;
            $collimatorData->machine_id = $machine->id;
            $collimatorData->tube_id = $tubeId;
            $collimatorData->sid = $wallSid;
            $collimatorData->receptor = 'Wall';
            $collimatorData->indicated_trans = $collimationWall[$i][0] == 'NA'? null : (float) $collimationWall[$i][0];
            $collimatorData->indicated_long = $collimationWall[$i][1] == 'NA' ? null : (float) $collimationWall[$i][1];
            $collimatorData->rad_trans = $collimationWall[$i][2] == 'NA' ? null : (float) $collimationWall[$i][2];
            $collimatorData->rad_long = $collimationWall[$i][3] == 'NA' ? null : (float) $collimationWall[$i][3];
            $collimatorData->light_trans = $collimationWall[$i][4] == 'NA' ? null : (float) $collimationWall[$i][4];
            $collimatorData->light_long = $collimationWall[$i][5] == 'NA' ? null : (float) $collimationWall[$i][5];
            $collimatorData->pbl_trans = $pblWall[$i][0] == 'NA' ? null : (float) $pblWall[$i][0];
            $collimatorData->pbl_long = $pblWall[$i][1] == 'NA' ? null : (float) $pblWall[$i][1];
            $collimatorData->save();
        }
        echo "Wall receptor collimator data saved.\n";

        // Large/small focus radiation output
        // Measured kV, mGy/mAs @ 40"
        $lfsOutput = $genFormSheet->rangeToArray('D1394:E1401', null, true, false, false);
        $sfsOutput = $genFormSheet->rangeToArray('D1407:E1412', null, true, false, false);
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
        echo "Large focus output data saved.\n";
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
        echo "Small focus output data saved.\n";

        // Load generator test data from cells AA688:BB747 into an array
        $genTestData = $genFormSheet->rangeToArray('AA688:BB747', null, true, false, true);
        // Insert generator test data into the database
        foreach ($genTestData as $genDataRow) {
            // Skip the record if it's empty
            if (empty($genDataRow['AZ'])) {
                continue;
            }

            $genData = new GenData();
            $genData->survey_id = $survey->id;
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
        echo "Generator test data saved.\n";

        // Get half value layer data
        // kV, HVL (mm Al)
        $hvls = $genFormSheet->rangeToArray('Y969:Z978', null, true, false, false);
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
        echo "HVL data saved.\n";

        return true;
    }
}
