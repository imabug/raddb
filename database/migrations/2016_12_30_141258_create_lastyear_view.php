<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastyearView extends Migration
{
    /**
     * Create a view containing surveys from the previous year
     * CREATE VIEW lastyear_view (machine_id,survey_id,test_date) AS
     * SELECT testdates.machine_id,testdates.id,testdates.test_date
     * FROM testdates
     * WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE())-1,1) AND MAKEDATE(YEAR(CURDATE()),1)
     * AND (testdates.type_id=1 or testdates.type_id=2)
     * ORDER BY testdates.test_date DESC
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW lastyear_view (machine_id,survey_id,test_date,report_file_path) AS
        SELECT machine_id,survey_id,test_date,report_file_path
        FROM testdates
        WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE())-1,1) AND MAKEDATE(YEAR(CURDATE()),1)
        AND (testdates.type_id=1 or testdates.type_id=2)
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
