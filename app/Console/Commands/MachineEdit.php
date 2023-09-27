<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class MachineEdit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machine:edit {machine_id? : ID of the machine to edit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit the details of a machine.  If a machine ID is not provided, a search dialog will be provided to search for a machine to edit';

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
        //
    }
}
