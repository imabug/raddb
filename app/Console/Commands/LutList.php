<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;

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
     */
    public function handle(): void
    {
        $table = Str::lower($this->argument('table'));
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
                error('Usage: php artisan lut:list <table>');
                exit;
                break;
        }

        $this->table($headers, $body);
    }
}
