<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

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
     */
    public function handle(): void
    {
        $table = Str::lower($this->argument('table'));
        $model = null;
        $field = '';

        // Get the current table
        switch ($table) {
            case 'location':
                $model = app(\App\Models\Location::class);
                $field = 'location';
                info('Editing Location table');
                break;
            case 'manufacturer':
                $model = app(\App\Models\Manufacturer::class);
                $field = 'manufacturer';
                info('Editing Manufacturer table');
                break;
            case 'modality':
                $model = app(\App\Models\Modality::class);
                $field = 'modality';
                info('Editing Modality table');
                break;
            case 'tester':
                $model = app(\App\Models\Tester::class);
                $field = 'name';
                info('Editing Tester table');
                break;
            case 'testtype':
                $model = app(\App\Models\TestType::class);
                $field = 'test_type';
                info('Editing TestType table');
                break;
            default:
                error('Usage: php artisan lut:edit <table>');
                exit();
                break;
        }

        if (is_object($model)) {
            // Show the selected lookup table
            $this->showTable($table);

            $id = text(label: 'Enter the ID of the entry to edit', required: true);

            $lut = $model::find($id); // Probably should fail more gracefully

            $value = text(label: 'What should the new value be?', required: true);

            if (confirm('Changing '.$lut->$field.' to '.$value.'.', default: false)) {
                $lut->$field = $value; // Need to validate this before saving
                $lut->save();
                // Show the updated lookup table
                $this->showTable($table);
                info($table.' table ID: '.$id.' edited.');
            } else {
                info('No changes made.');
            }
        }
    }
}
