<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Command;

class LutAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:add
                            {table : The lookup table to add to}';

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
        $lut = null;
        $table = strtolower($this->argument('table'));

        switch ($table) {
            case 'location':
                $lut = new Location();
                $lut->location = $this->ask('Enter a new location');
                break;
            case 'manufacturer':
                $lut = new Manufacturer();
                $lut->manufacturer = $this->ask('Enter a new manufacturer');
                break;
            case 'modality':
                $lut = new Modality();
                $lut->modality = $this->ask('Enter a new modality');
                break;
            case 'tester':
                $lut = new Tester();
                $lut->name = $this->ask('Enter new tester\'s name');
                $lut->initials = $this->ask('Enter tester\'s initials');
                break;
            case 'testtype':
                $lut = new TestType();
                $lut->test_type = $this->ask('Enter new test type');
                break;
            default:
                $this->error('Usage: php artisan lut:add <table>');
                break;
        }

        if (is_object($lut)) {
            $lut->save();
            $this->info('New '.$table.' entry saved.');
        }
    }
}
