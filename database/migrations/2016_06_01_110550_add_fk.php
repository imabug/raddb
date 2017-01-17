<?php

use Illuminate\Database\Migrations\Migration;

class AddFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        // Add foreign key to contacts table
        Schema::table('contacts', function ($table) {
            $table->foreign('location_id')->references('id')->on('locations');
        });

        // Add foreign keys to gendata table
        Schema::table('gendata', function ($table) {
            $table->foreign('survey_id')->references('id')->on('testdates');
            $table->foreign('tube_id')->references('id')->on('tubes');
        });

        // Add foreign keys to machines table
        Schema::table('machines', function ($table) {
            $table->foreign('modality_id')->references('id')->on('modalities');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('location_id')->references('id')->on('locations');
        });

        // Add foreign keys to opnotes table
        Schema::table('opnotes', function ($table) {
            $table->foreign('machine_id')->references('id')->on('machines');
        });

        // Add foreign keys to recommendations table
        Schema::table('recommendations', function ($table) {
            $table->foreign('survey_id')->references('id')->on('testdates');
        });

        // Add foreign keys to testdates table
        Schema::table('testdates', function ($table) {
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('tester1_id')->references('id')->on('testers');
            $table->foreign('tester2_id')->references('id')->on('testers');
            $table->foreign('type_id')->references('id')->on('testtypes');
        });

        // Add foreign keys to tubes table
        Schema::table('tubes', function ($table) {
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('housing_manuf_id')->references('id')->on('manufacturers');
            $table->foreign('insert_manuf_id')->references('id')->on('manufacturers');
        });

        Schema::enableForeignKeyConstraints();
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
