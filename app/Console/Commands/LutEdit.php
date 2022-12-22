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
     * @return mixed
     */
    public function handle()
    {
        $table = strtolower($this->argument('table'));
        $headers = ['ID', $table];
        $body = null;
        $model = null;
        $field = '';

        // Get the current table
        switch ($table) {
            case 'location':
                $model = app('App\Models\Location');
                $field = 'location';
                $this->info('Editing Location table');
                break;
            case 'manufacturer':
                $model = app('App\Models\Manufacturer');
                $field = 'manufacturer';
                $this->info('Editing Manufacturer table');
                break;
            case 'modality':
                $model = app('App\Models\Modality');
                $field = 'modality';
                $this->info('Editing Modality table');
                break;
            case 'tester':
                $model = app('App\Models\Tester');
                $field = 'name';
                $this->info('Editing Tester table');
                break;
            case 'testtype':
                $model = app('App\Models\TestType');
                $field = 'test_type';
                $this->info('Editing TestType table');
                break;
            default:
                $this->error('Usage: php artisan lut:edit <table>');
                break;
        }

        if (is_object($model)) {
            $body = $model::all(['id', $field])->toArray();

            // Show the current table
            $this->table($headers, $body);

            $id = $this->ask('Enter the ID of the entry to edit');

            $lut = $model::findOrFail($id); // Probably should fail more gracefully

            $value = $this->ask('What should the new value be?');

            $lut->$field = $value; // Need to validate this before saving
            $lut->save();

            // Refresh the table and display the modified table to the user
            $body = $model::all(['id', $field])->toArray();
            $this->table($headers, $body);

            $this->info($table.' table ID: '.$id.' edited.');
        }

        return;
    }
}
