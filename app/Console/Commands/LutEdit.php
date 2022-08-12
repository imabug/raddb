<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Command;

class LutEdit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:edit
                            {table : The lookup table to edit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit an entry in one of the lookup tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table = strtolower($this->argument('table'));
        $headers = ['ID', $table];
        $body = null;

        // Get the current table
        switch ($table) {
            case 'location':
                $body = Location::all(['id', 'location'])->toArray();
                $model = app('App\Models\Location');
                $field = 'location';
                $this->info('Editing Location table');
                break;
            case 'manufacturer':
                $body = Manufacturer::all(['id', 'manufacturer'])->toArray();
                $model = app('App\Models\Manufacturer');
                $field = 'manufacturer';
                $this->info('Editing Manufacturer table');
                break;
            case 'modality':
                $body = Modality::all(['id', 'modality'])->toArray();
                $model = app('App\Models\Modality');
                $field = 'modality';
                $this->info('Editing Modality table');
                break;
            case 'tester':
                $body = Tester::all(['id', 'name'])->toArray();
                $model = app('App\Models\Tester');
                $field = 'name';
                $this->info('Editing Tester table');
                break;
            case 'testtype':
                $body = TestType::all(['id', 'test_type'])->toArray();
                $model = app('App\Models\TestType');
                $field = 'test_type';
                $this->info('Editing TestType table');
                break;
            default:
                $this->error('Usage: php artisan lut:list <table>');
                break;
        }
        if (!is_null($body)) {
            // Show the current
            $this->table($headers, $body);
        }

        $id = $this->ask('Enter the ID of the entry to edit');

        $lut = $model::findOrFail($id);

        $value = $this->ask('What should the new value be?');

        // Check to make sure the value isn't already in the table
        if ($model::firstWhere($field, $value)) {
            $this->ask('Value already exists in the table.');

            return 0;
        } else {
            $lut->$field = $value;
            $lut->save();
            $this->info($location.' table ID: '.$id.' edited.');
        }

        return 1;
    }
}
