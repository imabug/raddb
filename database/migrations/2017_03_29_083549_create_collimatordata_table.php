<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollimatordataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collimatordata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->enum('receptor', ['None', 'Table', 'Wall'])->default('None');
            $table->float('sid')->nullable();
            $table->float('indicated_trans')->nullable();
            $table->float('indicated_long')->nullable();
            $table->float('rad_trans')->nullable();
            $table->float('rad_long')->nullable();
            $table->float('light_trans')->nullable();
            $table->float('light_long')->nullable();
            $table->float('pbl_cass_trans')->nullable();
            $table->float('pbl_cass_long')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add foreign key constraints
        // Schema::disableForeignKeyConstraints();
        // Schema::table('collimatordata', function (Blueprint $table) {
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
        Schema::dropIfExists('collimatordata');
    }
}
