<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGendataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gendata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->nullable()->unsigned();
            $table->integer('tube_id')->nullable()->unsigned();
            $table->tinyInteger('kv_set')->nullable()->unsigned();
            $table->float('ma_set')->nullable();
            $table->float('time_set')->nullable();
            $table->float('mas_set')->nullable();
            $table->float('add_filt')->nullable();
            $table->float('distance')->nullable();
            $table->float('kv_avg')->nullable();
            $table->float('kv_max')->nullable();
            $table->float('kv_eff')->nullable();
            $table->float('exp_time')->nullable();
            $table->float('exposure')->nullable();
            $table->tinyInteger('use_flags')->nullable()->unsigned();
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
        Schema::drop('gendata');
    }
}
