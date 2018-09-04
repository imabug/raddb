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
lastyear_view.survey_id as prev_survey_id, lastyear_view.test_date as prev_test_date,
thisyear_view.survey_id as curr_survey_id, thisyear_view.test_date as curr_test_date
from machines
left join thisyear_view on machines.id = thisyear_view.machine_id
left join lastyear_view on machines.id = lastyear_view.machine_id
where machines.machine_status="Active"
order by prev_test_date
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
