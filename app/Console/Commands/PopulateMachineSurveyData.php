<?php

namespace RadDB\Console\Commands;

use Illuminate\Console\Command;
use RadDB\CollimatorData;
use RadDB\FluoroData;
use RadDB\GenData;
use RadDB\HVLData;
use RadDB\MachineSurveyData;
use RadDB\MaxFluoroData;
use RadDB\RadiationOutput;
use RadDB\RadSurveyData;
use RadDB\ReceptorEntranceExp;

class PopulateMachineSurveyData extends Command
{
    /**
     * The purpose of this command is to take any existing survey data in the database
     * and populate the machine_surveydata table.
     * For each machine/survey ID combination contained in the survey data tables
     * (gendata, hvldata, fluorodata, maxfluorodata, collimatordata, radoutputdata,
     * radsurveydata, receptorentrance), a 1 is stored in the respective column
     * in the machine_surveydata table. NULL means there is no data available for
     * the test.
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:machinesurveydata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the machine_surveydata table';

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
     * @return bool
     */
    public function handle()
    {
        $genData = GenData::select('survey_id', 'machine_id')->distinct()->get();
        $hvlData = HVLData::select('survey_id', 'machine_id')->distinct()->get();
        $fluoroData = FluoroData::select('survey_id', 'machine_id')->distinct()->get();
        $maxFluoroData = MaxFluoroData::select('survey_id', 'machine_id')->distinct()->get();
        $radOutputData = RadiationOutput::select('survey_id', 'machine_id')->distinct()->get();
        $radSurveyData = RadSurveyData::select('survey_id', 'machine_id')->distinct()->get();
        $collimatorData = CollimatorData::select('survey_id', 'machine_id')->distinct()->get();
        $receptorEntrance = ReceptorEntranceExp::select('survey_id', 'machine_id')->distinct()->get();

        $this->info('GenData');
        $bar = $this->output->createProgressBar(count($genData));
        foreach ($genData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['gendata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nHVLData");
        $bar = $this->output->createProgressBar(count($hvlData));
        foreach ($hvlData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['hvldata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nFluoroData");
        $bar = $this->output->createProgressBar(count($fluoroData));
        foreach ($fluoroData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['fluorodata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nMaxFluoroData");
        $bar = $this->output->createProgressBar(count($maxFluoroData));
        foreach ($maxFluoroData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['maxfluorodata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nRadiationOutput");
        $bar = $this->output->createProgressBar(count($radOutputData));
        foreach ($radOutputData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['radoutputdata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nRadSurveyData");
        $bar = $this->output->createProgressBar(count($radSurveyData));
        foreach ($radSurveyData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['radsurveydata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nCollimatorData");
        $bar = $this->output->createProgressBar(count($collimatorData));
        foreach ($collimatorData as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['collimatordata' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nReceptorEntranceExp");
        $bar = $this->output->createProgressBar(count($receptorEntrance));
        foreach ($receptorEntrance as $v) {
            $machineSurveyData = new MachineSurveyData();
            $machineSurveyData::updateOrCreate(
                ['id' => $v->survey_id, 'machine_id' => $v->machine_id],
                ['receptorentrance' => 1]
            );
            $bar->advance();
        }
        $bar->finish();

        return 1;
    }
}
