<?php

namespace RadDB\Console\Commands;

use PHPExcel;
use RadDB\Tube;
use RadDB\GenData;
use RadDB\Machine;
use RadDB\TestDate;
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
    protected $description = 'Import data from radiographic spreadsheet';

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
    }
}
