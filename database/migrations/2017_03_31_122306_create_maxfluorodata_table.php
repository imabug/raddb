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
            $table->timestamps();
        });
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
