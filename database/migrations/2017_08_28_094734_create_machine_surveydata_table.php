->default(0)<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineSurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_surveydata', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('machine_id')->unsigned()->default(0);
            $table->boolean('gendata')->default(0);
            $table->boolean('collimatordata')->default(0);
            $table->boolean('radoutputdata')->default(0);
            $table->boolean('radsurveydata')->default(0);
            $table->boolean('hvldata')->default(0);
            $table->boolean('fluorodata')->default(0);
            $table->boolean('maxfluorodata')->default(0);
            $table->boolean('receptorentrance')->default(0);
            $table->index(['machine_id', 'id']);
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
