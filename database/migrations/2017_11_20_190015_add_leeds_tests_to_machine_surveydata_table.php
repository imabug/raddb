<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeedsTestsToMachineSurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add flags for Leeds test objects test data
        Schema::table('machine_surveydata', function (Blueprint $table) {
            $table->boolean('leeds_n3')->nullable()->default(null)->after('receptorentrance');
            $table->boolean('leeds_to10')->nullable()->default(null)->after('leeds_n3');
            $table->boolean('fluoro_resolution')->nullable()->default(null)->after('leeds_to10');
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
