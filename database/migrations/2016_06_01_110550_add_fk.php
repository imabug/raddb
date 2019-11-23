<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::disableForeignKeyConstraints();
        //
        // // Add foreign key to contacts table
        // Schema::table('contacts', function (Blueprint $table) {
        //     $table->foreign('location_id')->references('id')->on('locations');
        // });
        //
        // // Add foreign keys to gendata table
        // Schema::table('gendata', function (Blueprint $table) {
        //     $table->foreign('survey_id')->references('id')->on('testdates');
        //     $table->foreign('tube_id')->references('id')->on('tubes');
        // });
        //
        // // Add foreign keys to machines table
        // Schema::table('machines', function (Blueprint $table) {
        //     $table->foreign('modality_id')->references('id')->on('modalities');
        //     $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        //     $table->foreign('location_id')->references('id')->on('locations');
        // });
        //
        // // Add foreign keys to opnotes table
        // Schema::table('opnotes', function (Blueprint $table) {
        //     $table->foreign('machine_id')->references('id')->on('machines');
        // });
        //
        // // Add foreign keys to recommendations table
        // Schema::table('recommendations', function (Blueprint $table) {
        //     $table->foreign('survey_id')->references('id')->on('testdates');
        // });
        //
        // // Add foreign keys to testdates table
        // Schema::table('testdates', function (Blueprint $table) {
        //     $table->foreign('machine_id')->references('id')->on('machines');
        //     $table->foreign('tester1_id')->references('id')->on('testers');
        //     $table->foreign('tester2_id')->references('id')->on('testers');
        //     $table->foreign('type_id')->references('id')->on('testtypes');
        // });
        //
        // // Add foreign keys to tubes table
        // Schema::table('tubes', function (Blueprint $table) {
        //     $table->foreign('machine_id')->references('id')->on('machines');
        //     $table->foreign('housing_manuf_id')->references('id')->on('manufacturers');
        //     $table->foreign('insert_manuf_id')->references('id')->on('manufacturers');
        // });
        //
        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key constraints
        Schema::disableForeignKeyConstraints();

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_location_id_foreign');
        });
        Schema::table('gendata', function (Blueprint $table) {
            $table->dropForeign('gendata_survey_id_foreign');
            $table->dropForeign('gendata_tube_id_foreign');
        });
        Schema::table('machines', function (Blueprint $table) {
            $table->dropForeign('machines_modality_id_foreign');
            $table->dropForeign('machines_manufacturer_id_foreign');
            $table->dropForeign('machines_location_id_foreign');
        });
        Schema::table('opnotes', function (Blueprint $table) {
            $table->dropForeign('opnotes_machine_id_foreign');
        });
        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropForeign('recommendations_survey_id_foreign');
        });
        Schema::table('testdates', function (Blueprint $table) {
            $table->dropForeign('testdates_machine_id_foreign');
            $table->dropForeign('testdates_tester1_id_foreign');
            $table->dropForeign('testdates_tester2_id_foreign');
            $table->dropForeign('testdates_type_id_foreign');
        });
        Schema::table('tubes', function (Blueprint $table) {
            $table->dropForeign('tubes_machine_id_foreign');
            $table->dropForeign('tubes_housing_manuf_id_foreign');
            $table->dropForeign('tubes_insert_manuf_id_foreign');
        });

        Schema::enableForeignKeyConstraints();
    }
}
