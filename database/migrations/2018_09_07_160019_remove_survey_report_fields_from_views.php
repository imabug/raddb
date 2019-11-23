<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSurveyReportFieldsFromViews extends Migration
{
    /**
     * SQL used to modify the view.
     *
     * @return string
     */
    private function alterLastYearView(): string
    {
        return <<<'SQL'
alter view lastyear_view (machine_id,survey_id,test_date,recCount) as
SELECT machine_id,testdates.id as survey_id,test_date,count(recommendations.recommendation) AS recCount
FROM testdates
LEFT JOIN recommendations on testdates.id=recommendations.survey_id
WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE())-1,1) AND MAKEDATE(YEAR(CURDATE()),1)
AND (testdates.type_id=1 or testdates.type_id=2)
GROUP BY testdates.id
ORDER BY testdates.test_date ASC
SQL;
    }

    private function alterThisyearView(): string
    {
        return <<<'SQL'
alter view thisyear_view (machine_id,survey_id,test_date,recCount) AS
SELECT machine_id,testdates.id as survey_id,test_date,count(recommendations.recommendation) as recCount
FROM testdates
LEFT JOIN recommendations ON testdates.id=recommendations.survey_id
WHERE testdates.test_date BETWEEN MAKEDATE(YEAR(CURDATE()),1) AND MAKEDATE(YEAR(CURDATE())+1,1)
AND (testdates.type_id=1 or testdates.type_id=2)
GROUP BY testdates.id
ORDER BY testdates.test_date ASC
SQL;
    }

    private function alterSurveyScheduleView(): string
    {
        return <<<'SQL'
alter view surveyschedule_view as
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
order by lastyear_view.test_date
SQL;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->alterLastYearView());
        DB::statement($this->alterThisyearView());
        DB::statement($this->alterSurveyScheduleView());
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
