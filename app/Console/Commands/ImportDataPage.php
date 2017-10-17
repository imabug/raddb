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
     * @return mixed
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
            case "xls":
            case "xlsx":
            case "xlsm":
                $reader = \PHPExcel_IOFactory::createReader('Excel2007');
                break;
            case "ods":
                $reader = \PHPExcel_IOFactory::createReader('OOCalc');
                break;
            default:
                break;
        }
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($spreadsheetFile);
        $genFormSheet = $spreadsheet->getSheetByName('DataPage');
        $this->info('Spreadsheet loaded.');

    }
}
