<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Tube;
use Illuminate\Console\Command;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

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

        $tube = Tube::active()->forMachine($machine->id)->get();

        foreach ($tube as $t) {
        }

        return 0;
    }
}
