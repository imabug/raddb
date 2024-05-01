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

class SurveyCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:cancel {survey_id : Survey ID to cancel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel a survey';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (is_null($this->argument('survey_id'))) {
            // No survey ID was provided.  Prompt the user to select a survey ID
            $survey_id = text(
                label: 'Enter a survey ID to cancel',
                required: true);
        }

        // Validate the provided survey ID.  It needs to exist in the testdates table
        $validator = Validator::make(array($survey_id), [
            'survey_id' => 'required|integer|exists:testdates,id',
        ]);

        if ($validator->failes()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            return 1;
        }

        $survey = TestDate::find($survey_id);
        $survey->delete();

        info('Survey ID '.$survey_id.' has been deleted');
    }
}
