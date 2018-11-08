<?php

namespace RadDB\Console\Commands;

use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\Manufacturer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $locations = Location::all(['id', 'location']);
        $modalities = Modality::all(['id', 'modality']);
        $manufacturers = Manufacturer::all(['id', 'manufacturer']);
        $locHeader = ['ID', 'Location'];
        $modHeader = ['ID', 'Modality'];
        $manufHeader = ['ID', 'Manufacturer'];

        $machine = new Machine;

        $machine->description = $this->ask('Give a descriptive name for this machine');

        $this->table($locHeader, $locations->toArray());
        $machine->location_id = $this->ask('Enter the location ID for this machine');

        $this->table($modHeader, $modalities->toArray());
        $machine->modality_id = $this->ask('Enter the modality ID for this machine');

        $this->table($manufHeader, $manufacturers->toArray());
        $machine->manufacturer_id = $this->ask('Enter the manufacturer ID for this machine');

        $machine->model = $this->ask('Enter the model name for this machine');
        $machine->serial_number = $this->ask('Enter the serial number for this machine');
        $machine->manuf_date = $this->ask('Enter the manufacture date for this machine (YYYY-MM-DD)');
        $machine->install_date = $this->ask('Enter the installation date for this machine (YYYY-MM-DD)');
        $machine->room = $this->ask('Enter the room number for this machine');
        $machine->vend_site_id = $this->ask('Enter the vendor site ID for this machine');
        $machine->notes = $this->ask('Enter any special notes for this machine');
        $machine->machine_status = 'Active';

        $validator = Validator::make($machine, [
            'description' => 'required|string|max:100',
            'location_id' => 'required|integer|exists:location',
            'modality_id' => 'required|integer|exists:modality',
            'manufacturer_id' => 'required|integer|exists:manufacturer',
            'model' => 'string|max:50',
            'serial_number' => 'string',
            'manuf_date' => 'date',
            'install_date' => 'date',
            'room' => 'string|max:20',
            'vend_site_id' => 'string|max:30',
            'notes' => 'string',
        ]);
        dump($machine);
    }
}
