<?php

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
            $table->integer('machine_id')->unsigned()->nullable()->default(null);
            $table->boolean('gendata')->nullable()->default(null);
            $table->boolean('collimatordata')->nullable()->default(null);
            $table->boolean('radoutputdata')->nullable()->default(null);
            $table->boolean('radsurveydata')->nullable()->default(null);
            $table->boolean('hvldata')->nullable()->default(null);
            $table->boolean('fluorodata')->nullable()->default(null);
            $table->boolean('maxfluorodata')->nullable()->default(null);
            $table->boolean('receptorentrance')->nullable()->default(null);
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
