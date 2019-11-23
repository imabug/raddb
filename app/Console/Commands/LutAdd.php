<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use RadDB\Location;
use RadDB\Manufacturer;
use RadDB\Modality;
use RadDB\Tester;
use RadDB\TestType;

class LutAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:add
                            {table : The lookup table to add to}
                            {value : Value to add to the lookup table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new entry to one of the lookup tables.';

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
        $body = null;

        switch ($table) {
        case 'location':
            $location = Location::create(['location' => $tableValue]);
            $body = Location::all(['id', 'location'])->toArray();
            break;
        case 'manufacturer':
            $manufacturer = Manufacturer::create(['manufacturer' => $tableValue]);
            $body = Manufacturer::all(['id', 'manufacturer'])->toArray();
            break;
        case 'modality':
            $modality = Modality::create(['modality' => $tableValue]);
            $body = Modality::all(['id', 'modality'])->toArray();
            break;
        case 'tester':
            $tester = Tester::create(['tester' => $tableValue]);
            $body = Tester::all(['id', 'name'])->toArray();
            break;
        case 'testtype':
            $testtype = TestType::create(['test_type' => $tableValue]);
            $body = TestType::all(['id', 'test_type'])->toArray();
            break;
        default:
            $this->error('Usage: php artisan lut:add <table> <value>');

            return 0;
            break;
        }

        // Show the lookup table with the new value.
        $this->table($headers, $body);

        return true;
    }
}
