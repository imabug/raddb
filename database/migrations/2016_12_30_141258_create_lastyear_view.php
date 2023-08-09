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
