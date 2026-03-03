<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class LutDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lut:delete
                            {table : The lookup table to delete from}';

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
        $lut = null;
        $model = null;
        $field = '';

        switch ($table) {
            case 'location':
                $model = app(\App\Models\Location::class);
                $field = 'location';
                break;
            case 'manufacturer':
                $model = app(\App\Models\Manufacturer::class);
                $field = 'manufacturer';
                break;
            case 'modality':
                $model = app(\App\Models\Modality::class);
                $field = 'modality';
                break;
            case 'tester':
                $model = app(\App\Models\Tester::class);
                $field = 'name';
                break;
            case 'testtype':
                $model = app(\App\Models\TestType::class);
                $field = 'test_type';
                break;
            default:
                error('Usage: php artisan lut:delete <table>');
                exit;
                break;
        }

        // Show the selected lookup table
        $this->showTable($table);

        $lut = $model::find(text(label: 'Enter the ID to remove', required: true));

        // Ask for confirmation
        if (confirm(label: 'Deleting from '.$table.' ID:'.$lut->id.' Value: '.$lut->$field, default: false)) {
            $lut->delete();
            info($table.' ID:'.$lut->id.' deleted.');

            // Show the updated lookup table
            $this->showTable($table);
        } else {
            info('No changes made.');
        }
    }
}
