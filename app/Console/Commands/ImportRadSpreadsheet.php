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
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $genFormSheet = $spreadsheet->getSheetByName('Gen_form');

        // Get the survey ID
        $surveyId = (int) $genFormSheet->getCell('E14')->getCalculatedValue();

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
        $radSurvey->lfs_resolution = (float) $lfsResolution;
        $radSurvey->sfs_resolution = (float) $sfsResolution;

        // Table bucky SID (cm)
        $tableSid = $genFormSheet->getCell('K543')->getCalculatedValue();

        // Wall bucky SID (cm)
        $WallSid = $genFormSheet->getCell('C615')->getCalculatedValue();

        // Field size indicators, radiation/light field alignment for table bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationTable = $genFormSheet->rangeToArray('B554:G555', null, true, false, false);

        // Automatic collimation (PBL) for table bucky
        // First pair - Cassette size (cm)
        $pblTable = $genFormSheet->rangeToArray('B575:C576', null, true, false, false);

        // Radiation/film center distance (cm) for wall bucky.
        $radFilmCenterWall = $genFormSheet->getCell('C608')->getCalculatedValue();

        // Field size indicators, radiation/light field alignment for wall bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationWall = $genFormSheet->rangeToArray('D615:I616', null, true, false, false);

        // Automatic collimation (PBL) for wall bucky
        // First pair - Cassette size (cm)
        $pblWall = $genFormSheet->rangeToArray('C637:D638', null, true, false, false);

        // Insert the collimator data into the database

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
            $radOutput->kv = $l[0];
            $radOutput->output = $l[1];
            $radOutput->save();
        }
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
            $radOutput->kv = $S[0];
            $radOutput->output = $s[1];
            $radOutput->save();
        }

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
            $genData->machine_id = $machine->id;
            $genData->tube_id = $tubeId;
            $genData->kv_set = $genDataRow['AA'];
            $genData->ma_set = $genDataRow['AB'];
            $genData->time_set = $genDataRow['AC'];
            $genData->mas_set = $genDataRow['AD'];
            $genData->add_filt = $genDataRow['AF'];
            $genData->distance = $genDataRow['AH'];

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
            $genData->kv_avg = empty($genDataRow['AX']) ? null : $genDataRow['AX'];
            $genData->kv_max = empty($genDataRow['AY']) ? null : $genDataRow['AY'];
            $genData->kv_eff = empty($genDataRow['AZ']) ? null : $genDataRow['AZ'];
            $genData->exp_time = empty($genDataRow['BA']) ? null : $genDataRow['BA'];
            $genData->exposure = empty($genDataRow['BB']) ? null : $genDataRow['BB'];

            // Store the data
            $genData->save();
        }

        // Get half value layer data
        // kV, HVL (mm Al)
        $HVLs = $genFormSheet->rangeToArray('Y969:Z978', null, true, false, false);
        // Insert the HVL data into the database
        foreach ($HVLs as $HVL) {
            $HVLData = new HVLData();
            $HVLData->survey_id = $survey->id;
            $HVLData->machine_id = $machine->id;
            $HVLData->tube_id = $tubeId;
            if (! empty(HVL[0]) || ! empty(HVL[1])) {
                $HVLData->kv = $HVL[0];
                $HVLData->hvl = $HVL[1];
                $HVLData->save();
            } else {
                // Skip the record if it's empty
                continue;
            }
        }

        return true;
    }
}
