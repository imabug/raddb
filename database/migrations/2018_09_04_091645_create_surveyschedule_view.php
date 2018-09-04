<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyscheduleView extends Migration
{

    /**
     * SQL used to create the view
     *
     * @return string
     */
    private function createView(): string
    {
        return <<<SQL
create view surveyschedule_view as 
select machines.id,machines.description,
    lastyear_view.survey_id as prevSurveyID ,
    lastyear_view.test_date as prevSurveyDate,
    lastyear_view.report_file_path as prevSurveyReport,
    lastyear_view.recCount as prevRecCount,
    thisyear_view.survey_id as currSurveyID,
    thisyear_view.test_date as currSurveyDate,
    thisyear_view.report_file_path as currSurveyReport,
    thisyear_view.recCount as currRecCount
from machines
left join thisyear_view on machines.id = thisyear_view.machine_id
left join lastyear_view on machines.id = lastyear_view.machine_id
where machines.machine_status="Active"
order by lastyear_view.test_date
SQL;
    }

    /**
     * SQL used to drop the view if it exists
     *
     * @return string
     */
    private function dropView(): string
    {
        return <<<SQL
drop view if exists 'surveyschedule_view'
SQL;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }
}
