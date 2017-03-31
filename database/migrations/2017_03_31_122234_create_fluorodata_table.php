<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluoroDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluorodata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->float('field_size')->nullable();
            $table->float('atten')->nullable();
            $table->string('dose1_mode', 50)->nullable();
            $table->float('dose1_kv')->nullable();
            $table->float('dose1_ma')->nullable();
            $table->float('dose1_rate')->nullable();
            $table->string('dose2_mode', 50)->nullable();
            $table->float('dose2_kv')->nullable();
            $table->float('dose2_ma')->nullable();
            $table->float('dose2_rate')->nullable();
            $table->string('dose3_mode', 50)->nullable();
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
        Schema::dropIfExists('fluorodata');
    }
}
