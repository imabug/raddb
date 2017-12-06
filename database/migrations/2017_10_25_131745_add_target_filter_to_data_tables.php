<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetFilterToDataTables extends Migration
{
    /**
     * Add target_filter field (i.e. Mo/Mo, W/Rh) to accomodate mammography
     * data.
     *
     * @return void
     */
    public function up()
    {
        // Add a string field to hold mammo target/filter combination
        // Field will contain data in the format "target/filter"
        // i.e. Mo/Mo, Mo/Rh, W/Rh, etc.
        Schema::table('hvldata', function (Blueprint $table) {
            $table->string('target_filter', 6)
                ->nullable()->default(null)
                ->comment('Target/filter combo for mammo units')
                ->after('tube_id');
        });
        Schema::table('radoutputdata', function (Blueprint $table) {
            $table->string('target_filter', 6)
                ->nullable()->default(null)
                ->comment('Target/filter combo for mammo units')
                ->after('tube_id');
        });
        Schema::table('radsurveydata', function (Blueprint $table) {
            $table->string('target_filter', 6)
                ->nullable()->default(null)
                ->comment('Target/filter combo for mammo units')
                ->after('tube_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hvldata', function (Blueprint $table) {
            $table->dropColumn('target_filter');
        });
        Schema::table('radoutputdata', function (Blueprint $table) {
            $table->dropColumn('target_filter');
        });
        Schema::table('radsurveydata', function (Blueprint $table) {
            $table->dropColumn('target_filter');
        });
    }
}
