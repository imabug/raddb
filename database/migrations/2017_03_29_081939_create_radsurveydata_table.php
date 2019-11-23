<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadsurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radsurveydata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->float('sid_accuracy_error')->nullable();
            $table->float('avg_illumination')->nullable();
            $table->float('beam_alignment_error')->nullable();
            $table->float('rad_film_center_table')->nullable();
            $table->float('rad_film_center_wall')->nullable();
            $table->float('lfs_resolution')->nullable();
            $table->float('sfs_resolution')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add foreign key constraints
        // Schema::disableForeignKeyConstraints();
        // Schema::table('radsurveydata', function (Blueprint $table) {
        //     $table->foreign('survey_id')->references('id')->on('testdates');
        //     $table->foreign('machine_id')->references('id')->on('machines');
        //     $table->foreign('tube_id')->references('id')->on('tubes');
        // });
        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radsurveydata');
    }
}
