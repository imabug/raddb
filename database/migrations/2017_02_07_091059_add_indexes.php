<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add additional indexes to some tables. These indexes may or may not
        // be redundant
        Schema::table('recommendations', function (Blueprint $table) {
            $table->index('survey_id');
            $table->index('resolved');
        });
        Schema::table('machines', function (Blueprint $table) {
            $table->index('modality_id');
            $table->index('manufacturer_id');
            $table->index('location_id');
        });
        Schema::table('opnotes', function (Blueprint $table) {
            $table->index('machine_id');
        });

        Schema::table('testdates', function (Blueprint $table) {
            $table->index('machine_id');
            $table->index('tester1_id');
            $table->index('tester2_id');
            $table->index('type_id');
        });
        Schema::table('tubes', function (Blueprint $table) {
            $table->index('machine_id');
            $table->index('housing_manuf_id');
            $table->index('insert_manuf_id');
        })
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
