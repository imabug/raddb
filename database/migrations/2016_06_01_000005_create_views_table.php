<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLastyearView extends Migration
{
    /**
     * Create a view containing surveys from the previous year.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW lastyear_view (machine_id,survey_id,test_date,recCount) AS
        SELECT machine_id,testdates.id as survey_id,test_date,count(recommendations.recommendation) AS recCount
        FROM testdates
        LEFT JOIN recommendations on testdates.id=recommendations.survey_id
        WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE())-1,1) AND MAKEDATE(YEAR(CURDATE()),1)
        AND testdates.deleted_at IS NULL
        AND (testdates.type_id=1 or testdates.type_id=2)
        GROUP BY testdates.id
        ORDER BY testdates.id, testdates.test_date ASC
        ');

        DB::statement('
        CREATE VIEW thisyear_view (machine_id,survey_id,test_date,recCount) AS
        SELECT machine_id,testdates.id as survey_id,test_date,count(recommendations.recommendation) as recCount
        FROM testdates
        LEFT JOIN recommendations ON testdates.id=recommendations.survey_id
        WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE()),1) AND MAKEDATE(YEAR(CURDATE())+1,1)
        AND testdates.deleted_at IS NULL
        AND (testdates.type_id=1 OR testdates.type_id=2)
        GROUP BY testdates.id
        ORDER BY testdates.id, testdates.test_date ASC
        ');

        DB::statement('
        create view surveyschedule_view as
        select machines.id,machines.description,
        lastyear_view.survey_id as prevSurveyID ,
        lastyear_view.test_date as prevSurveyDate,
        lastyear_view.recCount as prevRecCount,
        thisyear_view.survey_id as currSurveyID,
        thisyear_view.test_date as currSurveyDate,
        thisyear_view.recCount as currRecCount
        from machines
        left join thisyear_view on machines.id = thisyear_view.machine_id
        left join lastyear_view on machines.id = lastyear_view.machine_id
        where machines.machine_status="Active"
        order by lastyear_view.machine_id, lastyear_view.test_date
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
