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
use Illuminate\Console\Command;
use PhpParser\Node\Expr\Cast\Array_;

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
     * Array of spreadsheet types.
     *
     * @var array
     */
    protected $sheetType = [
        'RAD',
        'FLUORO',
        'MAMMO_HOL',
        'MAMMO_SIE',
        'SBB',
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
        switch ($ext) {
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
        if (is_null($dataPage = $spreadsheet->getSheetByName('DataPage'))) {
            $this->error('Spreadsheet has no DataPage');

            return false;
        } else {
            $this->info('Spreadsheet loaded.');
        }

        // Figure out what type of spreadsheet has been loaded
        $sheetType = $dataPage->getCell('B1')->getCalculatedValue();

        // Pull info for this spreadsheet from the database
        // Get the survey ID
        $surveyId = (int) $dataPage->getCell('B2')->getCalculatedValue();
        $survey = TestDate::find($surveyId);
        $machine = Machine::find($survey->machine_id);
        $sheetData = [
            'surveyId' => $surveyId,
            'survey' => $survey,
            'machine' => $machine,
            'tubes' => Tube::where('machine_id', $machine->id)->active()->get(),
        ];

        switch ($sheetType) {
            case 'RAD':
                $status = $this->importRad($sheetData, $dataPage);
                break;
            case 'FLUORO':
                $status = $this->importFluoro($sheetData, $dataPage);
                break;
            case 'MAMMO_HOL':
                $status = $this->importMammoHol($sheetData, $dataPage);
                break;
            case 'MAMMO_SIE':
                $status = $this->importMammoSie($sheetData, $dataPage);
                break;
            case 'SBB':
                $status = $this->importSbb($sheetdata, $dataPage);
                break;
            default:
                $this->error('Not a compatible spreadsheet');
                break;
        }

        return $status;
    }

    /**
     * Import radiography spreadsheet data.
     *
     * @param array $sheetData
     * @param array $dataPage
     * @return bool
     */
    private function importRad($sheetData, $dataPage)
    {
    }

    /**
     * Import fluoroscopy spreadsheet data.
     *
     * @param array $sheetData
     * @param array $dataPage
     * @return bool
     */
    private function importFluoro($sheetData, $dataPage)
    {
    }

    /**
     * Import mammography (Hologic) spreadsheet data.
     *
     * @param array $sheetData
     * @param array $dataPage
     * @return bool
     */
    private function importMammoHol($sheetData, $dataPage)
    {
    }

    /**
     * Import mammography (Siemens) spreadsheet data.
     *
     * @param array $sheetData
     * @param array $dataPage
     * @return bool
     */
    private function importMammoSie($sheetData, $dataPage)
    {
    }

    /**
     * Import SBB spreadsheet data.
     *
     * @param array $sheetData
     * @param array $dataPage
     * @return bool
     */
    private function importSbb($sheetData, $dataPage)
    {
    }
}
