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
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
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
    public function handle(): int
    {
        $machine = new Machine();

        // Check if a machine ID was provided as an argument.  If not, ask the user to select a machine
        if (is_null($this->argument('machine_id'))) {
            $machine = Machine::find(
                search(
                    'Search for the machine description to edit',
                    fn (string $value) => strlen($value) > 0
                        ? Machine::active()->where('description', 'like', "%{$value}%")->orderBy('description')->pluck('description', 'id')->all()
                        : []
                )
            );
        } else {
            $machine = Machine::findOrFail($this->argument('machine_id'));
        }

        // Prompt the user to edit each machine attribute
        $machine->description = text(
            label: 'Set a new description (enter to leave unchanged)',
            default: $machine->description,
            required: true
        );

        $machine->location_id = select(
            label: 'Select a location for this machine (enter to leave unchanged)',
            options: Location::pluck('location', 'id'),
            default: $machine->location->id,
            scroll: 10
        );
        $machine->modality_id = select(
            label: 'Select a modality for this machine (enter to leave unchanged)',
            options: Modality::pluck('modality', 'id'),
            default: $machine->modality->id,
            scroll: 10
        );
        $machine->manufacturer_id = select(
            label: 'Select a manufacturer for this machine (enter to leave unchanged)',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $machine->manufacturer->id,
            scroll: 10
        );

        $machine->model = text(
            label: 'Enter the model name for this machine (enter to leave unchanged)',
            default: $machine->model,
            required: true
        );

        $machine->serial_number = text(
            label: 'Enter the serial number for this machine (enter to leave unchanged)',
            default: $machine->serial_number,
            required: true
        );

        $machine->manuf_date = text(
            label: 'Enter the manufacture date for this machine (YYYY-MM-DD) (enter to leave unchanged)',
            default: $machine->manuf_date,
            required: true
        );

        $machine->install_date = text(
            label: 'Enter the installation date for this machine (YYYY-MM-DD) (enter to leave unchanged)',
            default: $machine->install_date,
            required: true
        );

        $machine->room = text(
            label: 'Enter the room number for this machine (enter to leave unchanged)',
            default: $machine->room,
            required: true
        );

        $machine->software_version = text(
            label: 'Enter the software version (enter to leave unchanged)',
            default: $machine->software_version ?? ''
        );

        $machine->vend_site_id = text(
            label: 'Enter the vendor site ID for this machine (enter to leave unchanged)',
            default: $machine->vend_site_id ?? ''
        );

        $machine->notes = text(
            label: 'Enter any special notes for this machine (enter to leave unchanged)',
            default: $machine->notes ?? ''
        );

        $machine->machine_status = select(
            label: 'Select the machine status (enter to leave unchanged)',
            options: ['Active', 'Inactive', 'Removed'],
            default: $machine->machine_status
        );

        $validator = Validator::make($machine->toArray(), [
            'description'      => 'required|string|max:100',
            'model'            => 'required|string|max:50',
            'serial_number'    => 'required|string|max:20',
            'manuf_date'       => 'required|date',
            'install_date'     => 'required|date',
            'room'             => 'required|string|max:20',
            'software_version' => 'string|nullable',
            'vend_site_id'     => 'string|nullable',
            'notes'            => 'string|nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $message) {
                error($message);
            }

            // Validation failed. Return non-zero error code
            return 1;
        }

        if (confirm('Save these changes?')) {
            $machine->save();
            info('Changes have been saved');
        }

        return 0;
    }
}
