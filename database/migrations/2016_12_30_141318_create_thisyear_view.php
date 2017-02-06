<?php

use Illuminate\Database\Migrations\Migration;

class CreateThisyearView extends Migration
{
    /**
     * Create a view containing surveys from the previous year
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW thisyear_view (machine_id,survey_id,test_date,report_file_path,recCount) AS
        SELECT machine_id,id as survey_id,test_date,report_file_path,count(recommendations.recommendation) as recCount
        FROM testdates
        LEFT JOIN recommendations ON testdates.id=recommendations.survey_id
        WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE()),1) AND MAKEDATE(YEAR(CURDATE())+1,1)
        AND (testdates.type_id=1 or testdates.type_id=2)
        GROUP BY testdates.id
        ORDER BY testdates.test_date ASC
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
