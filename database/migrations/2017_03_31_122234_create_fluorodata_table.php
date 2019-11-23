<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFluoroDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluorodata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->nullable();
            $table->integer('machine_id')->unsigned()->nullable();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->float('field_size')->nullable();
            $table->float('atten')->nullable();
            $table->string('dose1_mode', 50)->nullable();
            $table->float('dose1_kv')->nullable();
            $table->float('dose1_ma')->nullable();
            $table->float('dose1_rate')->nullable();
            $table->string('dose2_mode', 50)->nullable();
            $table->float('dose2_kv')->nullable();
            $table->float('dose2_ma')->nullable();
            $table->float('dose2_rate')->nullable();
            $table->string('dose3_mode', 50)->nullable();
            $table->float('dose3_kv')->nullable();
            $table->float('dose3_ma')->nullable();
            $table->float('dose3_rate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // Add foreign key constraints
        // Schema::disableForeignKeyConstraints();
        // Schema::table('fluorodata', function (Blueprint $table) {
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
        Schema::dropIfExists('fluorodata');
    }
}
