<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecondFluoroColumnsInMachineSurveydata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machine_surveydata', function (Blueprint $table) {
            $table->boolean('fluorodata_2')->default(0)->after('receptorentrance_1')->comment('Pulse/Digital SEE');
            $table->boolean('maxfluorodata_2')->default(0)->after('fluorodata_2')->comment('Pulse/Digital max SEE');
            $table->boolean('receptorentrance_2')->default(0)->after('maxfluorodata_2')->comment('Pulse/Digital receptor entrance exposure');
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
