<?php

namespace RadDB\Console\Commands;

use RadDB\GenData;
use RadDB\HVLData;
use RadDB\FluoroData;
use RadDB\MaxFluoroData;
use RadDB\RadSurveyData;
use RadDB\CollimatorData;
use RadDB\RadiationOutput;
use RadDB\MachineSurveyData;
use RadDB\ReceptorEntranceExp;
use Illuminate\Console\Command;

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
        foreach ($genData as $g) {
            $machineSurveyData = MachineSurveyData::where('id', $g->survey_id)->where('machine_id', $g->machine_id)->first();
            $machineSurveyData->gendata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nHVLData");
        $bar = $this->output->createProgressBar(count($hvlData));
        foreach ($hvlData as $h) {
            $machineSurveyData = MachineSurveyData::where('id', $h->survey_id)->where('machine_id', $h->machine_id)->first();
            $machineSurveyData->hvldata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nFluoroData");
        $bar = $this->output->createProgressBar(count($fluoroData));
        foreach ($fluoroData as $f) {
            $machineSurveyData = MachineSurveyData::where('id', $f->survey_id)->where('machine_id', $f->machine_id)->first();
            $machineSurveyData->fluorodata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nMaxFluoroData");
        $bar = $this->output->createProgressBar(count($maxFluoroData));
        foreach ($maxFluoroData as $m) {
            $machineSurveyData = MachineSurveyData::where('id', $m->survey_id)->where('machine_id', $m->machine_id)->first();
            $machineSurveyData->maxfluorodata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nRadiationOutput");
        $bar = $this->output->createProgressBar(count($radOutputData));
        foreach ($radOutputData as $r) {
            $machineSurveyData = MachineSurveyData::where('id', $r->survey_id)->where('machine_id', $r->machine_id)->first();
            $machineSurveyData->radoutputdata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nRadSurveyData");
        $bar = $this->output->createProgressBar(count($radSurveyData));
        foreach ($radSurveyData as $r) {
            $machineSurveyData = MachineSurveyData::where('id', $r->survey_id)->where('machine_id', $r->machine_id)->first();
            $machineSurveyData->radsurveydata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nCollimatorData");
        $bar = $this->output->createProgressBar(count($collimatorData));
        foreach ($collimatorData as $c) {
            $machineSurveyData = MachineSurveyData::where('id', $c->survey_id)->where('machine_id', $c->machine_id)->first();
            $machineSurveyData->collimatordata = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        $this->info("\nReceptorEntranceExp");
        $bar = $this->output->createProgressBar(count($receptorEntrance));
        foreach ($receptorEntrance as $r) {
            $machineSurveyData = MachineSurveyData::where('id', $r->survey_id)->where('machine_id', $r->machine_id)->first();
            $machineSurveyData->receptorentrance = 1;
            $machineSurveyData->save();
            $bar->advance();
        }
        $bar->finish();

        return true;
    }
}
