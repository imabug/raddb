<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaxFluoroDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maxfluorodata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->float('dose1_kv')->nullable();
            $table->float('dose1_ma')->nullable();
            $table->float('dose1_rate')->nullable();
            $table->float('dose2_kv')->nullable();
            $table->float('dose2_ma')->nullable();
            $table->float('dose2_rate')->nullable();
            $table->float('dose3_kv')->nullable();
            $table->float('dose3_ma')->nullable();
            $table->float('dose3_rate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // Add foreign key constraints
        Schema::disableForeignKeyConstraints();
        Schema::table('maxfluorodata', function (Blueprint $table) {
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
        Schema::dropIfExists('maxfluorodata');
    }
}
