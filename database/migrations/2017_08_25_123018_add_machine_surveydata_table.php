<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMachineSurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_surveydata', function (Blueprint $table) {
            $table->integer('machine_id')->unsigned();
            $table->integer('survey_id')->unsigned();
            $table->boolean('gendata')->nullable();
            $table->boolean('collimatordata')->nullable();
            $table->boolean('radoutputdata')->nullable();
            $table->boolean('radsurveydata')->nullable();
            $table->boolean('hvldata')->nullable();
            $table->boolean('fluorodata')->nullable();
            $table->boolean('maxfluorodata')->nullable();
            $table->boolean('receptorentrance')->nullable();
            $table->index(['machine_id', 'survey_id']);
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('survey_id')->references('id')->on('testdates');
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
        //
    }
}
