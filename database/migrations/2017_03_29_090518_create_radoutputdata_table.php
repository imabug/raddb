<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadoutputdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radoutputdata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->enum('focus', ['Large', 'Small'])->default('Large');
            $table->float('kv')->nullable();
            $table->float('output', 8, 4)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add foreign key constraints
        // Schema::disableForeignKeyConstraints();
        // Schema::table('radoutputdata', function (Blueprint $table) {
        //     $table->foreign('survey_id')->references('id')->on('testdates');
        //     $table->foreign('machine_id')->references('id')->on('machines');
        //     $table->foreign('tube_id')->references('id')->on('tubes');
        // });
        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radoutputdata');
    }
}
