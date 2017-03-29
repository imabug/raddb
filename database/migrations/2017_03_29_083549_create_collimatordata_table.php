<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->float('table_sid')->nullable();
            $table->float('wall_sid')->nullable();
            $table->float('indicated_trans')->nullable();
            $table->float('indicated_long')->nullable();
            $table->float('rad_trans')->nullable();
            $table->float('rad_long')->nullable();
            $table->float('light_trans')->nullable();
            $table->float('light_long')->nullable();
            $table->float('pbl_trans')->nullable();
            $table->float('pbl_long')->nullable();
            $table->timestamps();
        });

        // Add foreign key constraints
        Schema::disableForeignKeyConstraints();
        Schema::table('hvldata', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('testdates');
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('tube_id')->references('id')->on('tubes');
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
        Schema::dropIfExists('collimatordata');
    }
}
