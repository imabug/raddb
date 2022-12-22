<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = strtolower($this->argument('table'));
        $lut = null;
        $model = null;
        $field = '';

        switch ($table) {
            case 'location':
                $model = app('App\Models\Location');
                $field = 'location';
                break;
            case 'manufacturer':
                $model = app('App\Models\Manufacturer');
                $field = 'manufacturer';
                break;
            case 'modality':
                $model = app('App\Models\Modality');
                $field = 'modality';
                break;
            case 'tester':
                $model = app('App\Models\Tester');
                $field = 'name';
                break;
            case 'testtype':
                $model = app('App\Models\TestType');
                $field = 'test_type';
                break;
            default:
                $this->error('Usage: php artisan lut:delete <table>');
                break;
        }

        if (is_object($model)) {
            // Show the selected lookup table
            $this->call('lut:list', [
                'table' => $table,
            ]);

            $lut = $model::find($this->ask('Enter the ID to remove'));

            $this->info('Deleting from '.$table.' ID:'.$lut->id.' Value: '.$lut->$field);

            // Ask for confirmation
            if ($this->confirm('Do you wish to continue?')) {
                $lut->delete();
                $this->info($table.' ID:'.$lut->id.' deleted.');

                // Show the updated lookup table
                $this->call('lut:list', [
                    'table' => $table,
                ]);
            } else {
                $this->info('No changes made.');
            }
        }

    }
}
