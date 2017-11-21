<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeedsN3Table extends Migration
{
    /**
     * Table for Leeds N3 ttest object data.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leeds_n3', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable()->default(null);
            $table->integer('machine_id')->unsigned()->nullable()->default(null);
            $table->integer('tube_id')->unsigned()->nullable()->default(null);
            $table->float('field_size')->nullable()->default(null);
            $table->float('n3')->nullable()->default(null)->comment('Leeds N3 low contrast');
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
        Schema::dropIfExists('leeds_n3');
    }
}
