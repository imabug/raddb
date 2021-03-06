<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use RadDB\Location;
use RadDB\Manufacturer;
use RadDB\Modality;
use RadDB\Tester;
use RadDB\TestType;

class LutList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:list {table : Lookup table to list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the entries from the specified lookup table.  Lookup table is one of location, manufacturer, modality,  tester, or testtype';

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
        $headers = ['ID', $table];
        $body = null;

        switch ($table) {
        case 'location':
            $body = Location::all(['id', 'location'])->toArray();
            break;
        case 'manufacturer':
            $body = Manufacturer::all(['id', 'manufacturer'])->toArray();
            break;
        case 'modality':
            $body = Modality::all(['id', 'modality'])->toArray();
            break;
        case 'tester':
            $body = Tester::all(['id', 'name'])->toArray();
            break;
        case 'testtype':
            $body = TestType::all(['id', 'test_type'])->toArray();
            break;
        default:
            $this->error('Usage: php artisan lut:list <table>');
            break;
        }
        if (! is_null($body)) {
            $this->table($headers, $body);
        }

        return 1;
    }
}
