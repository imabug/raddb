<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
