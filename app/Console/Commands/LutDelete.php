<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use RadDB\Location;
use RadDB\Manufacturer;
use RadDB\Modality;
use RadDB\Tester;
use RadDB\TestType;

class LutDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:delete
                            {table : The lookup table to delete from}
                            {value : Value to remove from the lookup table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an entry from a lookup table.  Lookup table is one of location, manufacturer, modality, tester, or testtype';

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
        $table = strtolower($this->argument('table'));
        $tableValue = $this->argument('value');
        $headers = ['ID', $table];
        $lut = null;

        // Show the lookup table
        $this->call('lut:list', [
            'table' => $table,
        ]);

        switch ($table) {
        case 'location':
            $lut = Location::where('location', $tableValue)->first();
            break;
        case 'manufacturer':
            $lut = Manufacturer::where('manufacturer', $tableValue)->first();
            break;
        case 'modality':
            $lut = Modality::where('modality', $tableValue)->first();
            break;
        case 'tester':
            $lut = Tester::where('tester', $tableValue)->first();
            break;
        case 'testtype':
            $lut = TestType::where('test_type', $tableValue)->first();
            break;
        default:
            $this->error('Usage: php artisan lut:delete <table> <value>');
            break;
        }

        if (! is_null($lut)) {
            // Ask for confirmation
            if ($this->confirm('Deleting '.$table.' ID:'.$lut->id.'. Do you wish to continue?')) {
                $lut->delete();
            }

            // Show the lookup table
            $this->call('lut:list', [
                'table' => $table,
            ]);

            $this->info($table.' ID:'.$lut->id.' deleted.');
        }

        return 1;
    }
}
