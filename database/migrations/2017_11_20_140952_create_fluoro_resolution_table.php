<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluoroResolutionTable extends Migration
{
    /**
     * Table for Huttner Type 18 resolution pattern data.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluoro_resolution', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable()->default(null);
            $table->integer('machine_id')->unsigned()->nullable()->default(null);
            $table->integer('tube_id')->unsigned()->nullable()->default(null);
            $table->float('field_size')->nullable()->default(null);
            $table->float('resolution')->nullable()->default(null)->comment('Resolution in lp/mm');
            $table->softDeletes();
            $table->timestamps();
            $table->index('field_size');
            $table->index('survey_id');
            $table->index('machine_id');
            $table->index('tube_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fluoro_resolution');
    }
}
