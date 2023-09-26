<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class MachineAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machine:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new machine to the database';

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
        $machine = new Machine();

        $machine->description = text('Give a descriptive name for this machine');

        $machine->location_id = select(
            label: 'Select a location for this machine',
            options: Location::pluck('location', 'id'),
            scroll: 10
        );
        $machine->modality_id = select(
            label: 'Select a modality for this machine',
            options: Modality::pluck('modality', 'id'),
            scroll: 10
        );
        $machine->manufacturer_id = select(
            label: 'Select a manufacturer for this machine',
            options: Manufacturer::pluck('manufacturer', 'id'),
            scroll: 10
        );

        $machine->model = text('Enter the model name for this machine');
        $machine->serial_number = text(label: 'Enter the serial number for this machine', required: true);
        $machine->manuf_date = text('Enter the manufacture date for this machine (YYYY-MM-DD)');
        $machine->install_date = text('Enter the installation date for this machine (YYYY-MM-DD)');
        $machine->room = text(label: 'Enter the room number for this machine', required: true);
        $machine->vend_site_id = text('Enter the vendor site ID for this machine');
        $machine->notes = text('Enter any special notes for this machine');
        $machine->machine_status = 'Active';

        $validator = Validator::make($machine->toArray(), [
            'description'     => 'required|string|max:100',
            'model'           => 'required|string|max:50',
            'serial_number'   => 'required|string|max:20',
            'manuf_date'      => 'required|date',
            'install_date'    => 'required|date',
            'room'            => 'required|string|max:20',
            'vend_site_id'    => 'string|nullable',
            'notes'           => 'string|nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $message) {
                error($message);
            }

            return 1;
        } else {
            // Everything passed.  Save the new machine.
            $machine->save();
            // Now add a new tube for the machine.
            $this->call('tube:add', [
                'machine_id' => $machine->id,
            ]);
        }

        return 0;
    }
}
