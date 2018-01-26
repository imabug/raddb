<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMamlinearityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mamlinearity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->integer('machine_id')->unsigned();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->string('target_filter', 6);
            $table->smallInteger('mAs')->unsigned();
            $table->float('output', 5, 2)->comment('mGy/mAs');
            $table->softDeletes();
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
        Schema::dropIfExists('mamlinearity');
    }
}
