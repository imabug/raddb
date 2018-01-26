<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMamsurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mamsurveydata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->integer('machine_id')->unsigned();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->string('target_filter', 6);
            $table->float('avg_illumination')->nullable();
            $table->float('2D_MGD', 4, 2)->nullable();
            $table->float('3D_MGD', 4, 2)->nullable();
            $table->float('Combo_MGD', 4, 2)->nullable();
            $table->float('CNR', 5, 2)->nullable();
            $table->float('SNR', 5, 2)->nullable();
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
        Schema::dropIfExists('mamsurveydata');
    }
}
