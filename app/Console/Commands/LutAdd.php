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
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

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
     */
    public function handle(): void
    {
        $lut = null;
        $table = Str::lower($this->argument('table'));

        switch ($table) {
            case 'location':
                $lut = new Location();
                $lut->location = text(
                    label: 'Enter a new location',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                          Str::length($value) > 100 => 'The location must be less than 100 characters',
                                          default => null
                                      });
                break;
            case 'manufacturer':
                $lut = new Manufacturer();
                $lut->manufacturer = text(
                    label: 'Enter a new manufacturer',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                              Str::length($value) > 50 => 'The manufacturer must be less than 50 characters',
                                              default => null
                                      });
                break;
            case 'modality':
                $lut = new Modality();
                $lut->modality = text(
                    label: 'Enter a new modality',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                          Str::length($value) > 25 => 'The modality must be less than 25 characters',
                                          default => null
                                      });
                break;
            case 'tester':
                $lut = new Tester();
                $lut->name = text(
                    label: 'Enter a new tester\'s name',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                          Str::length($value) > 25 => 'The name must be less than 25 characters',
                                          default => null
                                      });
                $lut->initials = text(
                    label: 'Enter tester\'s initials',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                          Str::length($value) > 4 => 'The initials must be less than 4 characters',
                                          default => null
                                      });
                break;
            case 'testtype':
                $lut = new TestType();
                $lut->test_type = text(
                    label: 'Enter a new test type',
                    required: true,
                    validate: fn (string $value) => match (true) {
                                           Str::length($value) > 30 => 'The test type must be less than 30 characters',
                                           default => null
                                      });
                break;
            default:
                error('Usage: php artisan lut:add <table>');
                exit();
                break;
        }

        if (is_object($lut)) {
            $lut->save();
            info('New '.$table.' entry saved.');
        }
    }
}
