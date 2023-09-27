<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\TestDate;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SurveyAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:add {machine_id? : Machine ID to add a survey for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new survey for a machine.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $testdate = new TestDate();

        if (is_null($this->argument('machine_id'))) {
            // No machine ID was provided.  Prompt the user to select a machine
            $testdate->machine_id = search(
                'Search for the machine description to add a survey for',
                fn (string $value) => strlen($value) > 0
                    ? Machine::active()->where('description', 'like', "%{$value}%")->orderBy('description')->pluck('description', 'id')->all()
                    : []
            );
        } else {
            // Check the validity of the machine id
            $validator = Validator::make($testdate->toArray(), [
                'machine_id' => 'required|integer|exists:machines,id',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    error($message);
                }

                return 1;
            }
            $testdate->machine_id = $this->argument('machine_id');
        }

        $testdate->test_date = text('Enter the date of the survey (YYYY-MM-DD)');
        $testdate->tester1_id = select(
            label: 'Select the first tester initials',
            options: Tester::pluck('initials', 'id'),
            scroll: 10
        );
        $testdate->tester2_id = select(
            label: 'Select the second tester initials',
            options: Tester::pluck('initials', 'id'),
            scroll: 10
        );
        $testdate->type_id = select(
            label: 'Select the test type',
            options: TestType::pluck('test_type', 'id'),
            scroll: 10
        );
        $testdate->accession = text('Enter the accession number for this survey');
        $testdate->notes = text('Enter any notes for this survey');

        // Validate the data entered by the user
        $validator = Validator::make($testdate->toArray(), [
            'test_date' => 'required|date',
            'accession' => 'string|max:50',
            'notes'     => 'string', ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            // Exit with a non-zero code
            return 1;
        }
        // Save the survey
        $testdate->save();

        info('Survey ID '.$testdate->id.' has been added for '.$testdate->machine->description.'.');

        return 0;
    }
}
