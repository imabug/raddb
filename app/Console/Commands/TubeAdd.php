<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Tube;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;
use function Laravel\Prompts\text;

class TubeAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tube:add {machine_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new tube for a machine';

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
    public function handle(): int
    {
        $manufacturers = Manufacturer::all(['id', 'manufacturer']);

        $manufHeader = ['ID', 'Manufacturer'];

        $tube = new Tube();

        if (is_null($this->argument('machine_id'))) {
            // No machine ID was provided.  Display a list of all the machines and ask for a machine ID to add the new tube to.
            $machines = Machine::all(['id', 'description']);
            $machHeader = ['ID', 'Machine'];
            $this->table($machHeader, $machines->toArray());
            $tube->machine_id = text('Enter the machine ID to add a tube for');
        } else {
            $tube->machine_id = $this->argument('machine_id');
        }

        // Check the validity of the machine_id.
        $validator = Validator::make($tube->toArray(), [
            'machine_id' => 'required|integer|exists:machines,id',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }

            return 1;
        }

        // Valid machine_id.  Proceed with getting the rest of the tube information.
        $this->call('lut:list', ['table' => 'manufacturer']);
        $tube->housing_manuf_id = text('Enter the manufacturer ID for the tube');
        $tube->insert_manuf_id = $tube->housing_manuf_id;

        // Validate the manufacturer ID provided.
        $validator = Validator::make($tube->toArray(), [
            'housing_manuf_id' => 'required|integer|exists:manufacturers,id',
            'insert_manuf_id'  => 'required|integer|exists:manufacturers,id',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }

            return 1;
        }

        // Get the rest of the tube information.
        $tube->housing_model = text('Enter the tube housing model');
        $tube->housing_sn = text('Enter the tube housing serial number');
        $tube->insert_model = text('Enter the tube insert model');
        $tube->insert_sn = text('Enter the tube insert serial number');
        $tube->manuf_date = text('Enter the manufacture date for the tube (YYYY-MM-DD)');
        $tube->install_date = text('Enter the installation date for the tube (YYYY-MM-DD)');
        $tube->lfs = text('Enter the large focal spot size');
        $tube->mfs = text('Enter the medium focal spot size');
        $tube->sfs = text('Enter the small focal spot size');
        $tube->notes = text('Enter any notes for this tube');
        $tube->tube_status = 'Active';

        // Validate the rest of the tube information.
        $validator = Validator::make($tube->toArray(), [
            'housing_model' => 'required|string|max:50',
            'housing_sn'    => 'required|string|max:20',
            'insert_model'  => 'required|string|max:50',
            'insert_sn'     => 'required|string|max:20',
            'manuf_date'    => 'required|date',
            'install_date'  => 'required|date',
            'lfs'           => 'required|numeric',
            'mfs'           => 'nullable|numeric',
            'sfs'           => 'required|numeric',
            'notes'         => 'nullable|string',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $this->error($message);
            }

            return 0;
        } else {
            // Everything validated.  Save the new tube.
            $tube->save();
        }

        return 1;
    }
}
