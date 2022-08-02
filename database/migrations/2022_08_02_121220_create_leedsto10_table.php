<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leeds_to10', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id')->unsigned()->nullable()->default(null);
            $table->integer('machine_id')->unsigned()->nullable()->default(null);
            $table->integer('tube_id')->unsigned()->nullable()->default(null);
            $table->float('field_size')->unsigned()->nullable()->default(null);
            $table->char('to10_row', 1)->nullable()->default(null);
            $table->float('cd')->unsigned()->nullable()->default(null)->comment('Contrast detail');
            $table->float('ti')->unsigned()->nullable()->default(null)->comment('Threshold index');
            $table->softDeletes();
            $table->timestamps();
            $table->index('survey_id');
            $table->index('machine_id');
            $table->index('tube_id');
            $table->index('field_size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leeds_to10');
    }
};
