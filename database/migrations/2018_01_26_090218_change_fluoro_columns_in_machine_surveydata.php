<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFluoroColumnsInMachineSurveydata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machine_surveydata', function (Blueprint $table) {
            $table->renameColumn('fluorodata', 'fluorodata_1');
            $table->renameColumn('maxfluorodata', 'maxfluorodata_1');
            $table->renameColumn('receptorentrance', 'receptorentrance_1');
        });
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
