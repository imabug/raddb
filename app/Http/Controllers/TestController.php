<?php

namespace RadDB\Http\Controllers;

use RadDB\Tube;
use RadDB\GenData;
use RadDB\Machine;
use RadDB\TestDate;
use Illuminate\Http\Request;
use PHPExcel;

class TestController extends Controller
{
    const LINEARITY = 0b0001;
    const ACCURACY = 0b0010;
    const BEAMQUAL = 0b0100;
    const REPRO = 0b1000;

     /**
      * Load an Excel spreadsheet file
      *
      * @param string $file
      *
      * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
      */
    public function loadXlsSpreadsheet()
    {
        $file = public_path().'/'.'Trauma1.xlsm';
        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $genFormSheet = $spreadsheet->getSheetByName('Gen_form');

        $surveyId = (int) $genFormSheet->getCell('E14')->getCalculatedValue();

        // SID Indicator accuracy error.
        $sidAccuracyError = $genFormSheet->getCell('G484')->getCalculatedValue();
        // Average illumination in lux.
        $avgIllumination = $genFormSheet->getCell('I504')->getCalculatedValue();
        // Beam alignment error.
        $beamAlignmentErr = $genFormSheet->getCell('G537')->getCalculatedValue();
        // Radiation/film center distance (cm) for table bucky.
        $radFilmCenterTable = $genFormSheet->getCell('C547')->getCalculatedValue();
        // Field size indicators, radiation/light field alignment for table bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationTable = $genFormSheet->rangeToArray('B554:G555', null, true, false, false);
        // Automatic collimation (PBL) for table bucky
        // First pair - Cassette size (cm)
        // Second pair - Radiation field size (cm)
        $pblTable = $genFormSheet->rangeToArray('B575:H576', null, true, false, false);
        // Radiation/film center distance (cm) for wall bucky.
        $radFilmCenterWall = $genFormSheet->getCell('C608')->getCalculatedValue();
        // Field size indicators, radiation/light field alignment for wall bucky
        // First pair - Indicated field size
        // Second pair - Radiation field
        // Third pair - Light field
        $collimationWall = $genFormSheet->rangeToArray('D615:I616', null, true, false, false);
        // Automatic collimation (PBL) for wall bucky
        // First pair - Cassette size (cm)
        // Second pair - Radiation field size (cm)
        $pblWall = $genFormSheet->rangeToArray('C637:F638', null, true, false, false);
        // Large/small focal spot resolution (lp/mm)
        $lfsResolution = $genFormSheet->getCell('I672')->getCalculatedValue();
        $sfsResolution = $genFormSheet->getCell('I677')->getCalculatedValue();
        // Large/small focus radiation output
        // Measured kV, mGy/mAs @ 40"
        $lfsOutput = $genFormSheet->rangeToArray('D1394:E1401', null, true, false, false);
        $sfsOutput = $genFormSheet->rangeToArray('D1407:E1412', null, true, false, false);

        // Load generator test data from cells AA688:BB747 into an array
        $genTestData = $genFormSheet->rangeToArray('AA688:BB747', null, true, false, true);
        if ($this->processGenData($surveyId, $genTestData)) {
            echo "<p>Generator data added</p>";
        }
        else {
            echo "<p>Generator data not added</p>";
        }

        // Get half value layer data
        // kV, HVL (mm Al)
        $HVLs = $genFormSheet->rangeToArray('Y969:Z978', null, true, false, false);

        return;
    }

    /**
     * Process generator test data.
     *
     * @param int $surveyId
     * @param array $genTesetData
     *
     * @return boolean
     */
    public function processGenData(int $surveyId, $genTestData)
    {
        $survey = TestDate::find(1938);
        $machine = Machine::find($survey->machine_id);
        $tube = Tube::where('machine_id', $machine->id)->active()->get()->first();

        foreach ($genTestData as $genDataRow) {
            // If there is no recorded data, skip this record
            if (empty($genDataRow['AZ'])) continue;

            $genData = new GenData();
            $genData->survey_id = $survey->id;
            $genData->tube_id = $tube->id;
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
        return true;
    }

    /**
     * Load a LibreOffice spreadsheet
     *
     * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
     */
    public function loadOdsSpreadsheet()
    {
        $file = public_path().'/'.'HVC01.ods';
        $reader = \PHPExcel_IOFactory::createReader('OOCalc');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);

        $fluoroSheet = $spreadsheet->getSheetByName('Fluoro');

        $surveyId = (int) $fluoroSheet->getCell('F13')->getCalculatedValue();
        $hvl = (float) $fluoroSheet->getCell('X174')->getCalculatedValue();

        $fluoroEntranceExpRate = $fluoroSheet->rangeToArray('C205:M219', null, true, false, false);
        $maxFluoroEntraceExpRate = $fluoroSheet->rangeToArray('E220:M220', null, true, false, false);
        $fluoroReceptorEntrExpRate = $fluoroSheet->rangeToArray('C237:H251', null, true, false, false);
        $digEntranceExpRate = $fluoroSheet->rangeToArray('C271:M285', null, true, false, false);
        $maxDigEntranceExpRate = $fluoroSheet->rangeToArray('E286:M286', null, true, false, false);
        $digReceptorEntrExpRate = $fluoroSheet->rangeToArray('C300:H314', null, true, false, false);

        return;
    }
}
