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
        $table = strtolower($this->argument('table'));

        switch ($table) {
            case 'location':
                $l = new Location();
                $l->location = $this->ask('Enter a new location');
                $l->save(); // Need to do some validation on the new location before saving
                break;
            case 'manufacturer':
                $m = new Manufacturer();
                $m->manufacturer = $this->ask('Enter a new manufacturer');
                $m->save();
                break;
            case 'modality':
                $m = new Modality();
                $m->modality = $this->ask('Enter a new modality');
                $m->save();
                break;
            case 'tester':
                $t = new Tester();
                $t->name = $this->ask('Enter new tester\'s name');
                $t->initials = $this->ask('Enter tester\'s initials');
                $t->save();
                break;
            case 'testtype':
                $testtype = new TestType();
                $t->test_type = $this->ask('Enter new test type');
                $t->save();
                break;
            default:
                $this->error('Usage: php artisan lut:add <table>');

                return 0;
                break;
        }

        return 1;
    }
}
