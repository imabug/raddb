<?php

namespace App\Console\Commands;

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
     * Call lut:list console command to display the lookup table.
     *
     * @param string $table Name of the table to display
     */
    public function showTable(string $table)
    {
        $this->call('lut:list', [
            'table' => $table,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = strtolower($this->argument('table'));
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
            // Show the selected lookup table
            $this->showTable($table);

            $id = $this->ask('Enter the ID of the entry to edit');

            $lut = $model::find($id); // Probably should fail more gracefully

            $value = $this->ask('What should the new value be?');

            $this->info('Changing '.$lut->$field.' to '.$value.'.');

            if ($this->confirm('Do you wish to continue?')) {
                $lut->$field = $value; // Need to validate this before saving
                $lut->save();
                // Show the updated lookup table
                $this->showTable($table);
                $this->info($table.' table ID: '.$id.' edited.');
            } else {
                $this->info('No changes made.');
            }
        }
    }
}
