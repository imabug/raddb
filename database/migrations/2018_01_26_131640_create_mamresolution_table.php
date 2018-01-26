<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMamresolutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mamresolution', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->integer('machine_id')->unsigned();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->string('target_filter',6);
            $table->enum('mode', ['2D', '3D'])->default('2D');
            $table->enum('fs_size', ['Large', 'Small'])->default('Large');
            $table->tinyInteger('kv');
            $table->float('resolution', 4, 2)->comment('lp/mm');
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
        Schema::dropIfExists('mamresolution');
    }
}
