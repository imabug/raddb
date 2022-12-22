<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Command;

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
        $value = $this->argument('value');
        $lut = null;
        $lutValue = '';

        // Show the lookup table
        $this->call('lut:list', [
            'table' => $table,
        ]);

        switch ($table) {
            case 'location':
                $lut = Location::where('location', $value)->firstOrFail();
                $lutValue = $lut->location;
                break;
            case 'manufacturer':
                $lut = Manufacturer::where('manufacturer', $value)->firstOrFail();
                $lutValue = $lut->manufacturer;
                break;
            case 'modality':
                $lut = Modality::where('modality', $value)->firstOrFail();
                $lutValue = $lut->modality;
                break;
            case 'tester':
                $lut = Tester::where('tester', $value)->firstOrFail();
                $lutValue = $lut->tester;
                break;
            case 'testtype':
                $lut = TestType::where('test_type', $value)->firstOrFail();
                $lutValue = $lut->test_type;
                break;
            default:
                $this->error('Usage: php artisan lut:delete <table> <value>');
                break;
        }

        if (is_object($lut)) {
            // Ask for confirmation
            if ($this->confirm('Deleting '.$table.' ID:'.$lut->id.' Value: '.$lutValue.'. Do you wish to continue?')) {
                $lut->delete();
            }

            // Show the lookup table
            $this->call('lut:list', [
                'table' => $table,
            ]);

            $this->info($table.' ID:'.$lut->id.' deleted.');
        }

    }
}
