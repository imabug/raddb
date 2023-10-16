<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Tube;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class TubeEdit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tube:edit {machine_id? : ID of the machine to edit the tube(s) for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit the details of an x-ray tube.  If a machine ID is not provided, a search dialog will be provided to search for a machine to edit the tube(s) for.';

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
     * @return int
     */
    public function handle(): int
    {
        $machine = new Machine();
        $tube = new Tube();

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

        if ($machine->tube()->count() > 1) {
            // Machine has more than one tube.  Ask the user which one to edit
            $t = Tube::find(
                select(
                    label: 'Select the tube to edit',
                    options: $machine->tube()->pluck('notes', 'id'),
                    scroll: 5
                )
            );
        }
        else {
            $t = $machine->tube()->get();
        }

        // Prompt the user to edit each tube attribute
        $t->housing_model = text(
            label: 'Set a new tube housing model (enter to leave unchanged)',
            default: $t->housing_model,
            required: true
        );

        $t->housing_sn = text(
            label: 'Set a new tube housing serial number (enter to leave unchanged)',
            default: $t->housing_sn,
            required: true
        );

        $t->housing_manuf_id = select(
            label: 'Select a manufacturer for this tube housing (enter to leave unchanged)',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $t->housing_manuf_id,
            scroll: 10
        );

        $t->insert_model = text(
            label: 'Set a new tube insert model (enter to leave unchanged)',
            default: $t->insert_model,
            required: true
        );

        $t->insert_sn = text(
            label: 'Set a new tube insert serial number (enter to leave unchanged)',
            default: $t->insert_sn,
            required: true
        );

        $t->insert_manuf_id = select(
            label: 'Select a manufacturer for this tube insert (enter to leave unchanged)',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $t->insert_manuf_id,
            scroll: 10
        );

        $t->manuf_date = text(
            label: 'Enter the manufacture date for the tube (YYYY-MM-DD) (enter to leave unchanged)',
            default: $t->manuf_date,
            required: true
        );

        $t->install_date = text(
            label: 'Enter the install date for the tube (YYYY-MM-DD) (enter to leave unchanged)',
            default: $t->install_date,
            required: true
        );

        $t->lfs = text(
            label: 'Enter the large focal spot size (mm) (enter to leave unchanged)',
            default: $t->lfs,
            required: true
        );

        $t->mfs = text(
            label: 'Enter the medium focal spot size (mm) (enter to leave unchanged)',
            default: $t->mfs,
        );

        $t->sfs = text(
            label: 'Enter the small focal spot size (mm) (enter to leave unchanged)',
            default: $t->sfs,
            required: true
        );

        $t->tube_status = select(
            label: 'Select the tube status (enter to leave unchanged)',
            options: ['Active', 'Inactive', 'Removed'],
            default: $t->tube_status,
            required: true
        );

        $t->notes = text(
            label: 'Enter any special notes for this tube (enter to leave unchanged)',
            default: $t->notes,
            required: true
        );

        $validator = Validator::make($t->toArray(), [
            'housing_model' => 'required|string|max:50',
            'housing_sn' => 'required|string|max:20',
            'insert_model' => 'required|string|max:50',
            'insert_sn' => 'required|string|max:20',
            'manuf_date' => 'required|date',
            'install_date' => 'required|date',
            'lfs' => 'required|decimal:1',
            'mfs' => 'decimal:1|nullable',
            'sfs' => 'required|decimal:1',
            'notes' => 'required|string|nullable',
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
            $t->save();
            info('Changes have been saved');
        }

        return 0;
    }
}
