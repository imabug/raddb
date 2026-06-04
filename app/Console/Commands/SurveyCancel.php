<?php

namespace App\Console\Commands;

use App\Models\TestDate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class SurveyCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel a survey';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $survey_id = text(
            label: 'Enter a survey ID to cancel',
            required: true
        );

        // Validate the provided survey ID.  It needs to exist in the testdates table
        $validator = Validator::make([$survey_id], [
            'survey_id' => 'required|integer|exists:testdates,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }

            return 1;
        }

        $survey = TestDate::find($survey_id);
        $survey->delete();

        info('Survey ID '.$survey_id.' has been deleted');

        return 0;
    }
}
