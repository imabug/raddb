<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;

class ImportFluoroSpreadsheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fluoro';

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

        $reader = \PHPExcel_IOFactory::createReader('OOCalc');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $genFormSheet = $spreadsheet->getSheetByName('Fluoro');
        $surveyId = (int) $fluoroSheet->getCell('F13')->getCalculatedValue();
        $hvl = (float) $fluoroSheet->getCell('X174')->getCalculatedValue();
        $fluoroEntranceExpRate = $fluoroSheet->rangeToArray('C205:M219', null, true, false, false);
        $maxFluoroEntraceExpRate = $fluoroSheet->rangeToArray('E220:M220', null, true, false, false);
        $fluoroReceptorEntrExpRate = $fluoroSheet->rangeToArray('C237:H251', null, true, false, false);
        $digEntranceExpRate = $fluoroSheet->rangeToArray('C271:M285', null, true, false, false);
        $maxDigEntranceExpRate = $fluoroSheet->rangeToArray('E286:M286', null, true, false, false);
        $digReceptorEntrExpRate = $fluoroSheet->rangeToArray('C300:H314', null, true, false, false);
    }
}
