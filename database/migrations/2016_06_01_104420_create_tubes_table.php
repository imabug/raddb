<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tubes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->default(0)->unsigned();
            $table->string('housing_model', 50)->nullable();
            $table->string('housing_sn', 20)->nullable();
            $table->integer('housing_manuf_id')->default(0)->unsigned();
            $table->string('insert_model', 50)->nullable();
            $table->string('insert_sn', 20)->nullable();
            $table->integer('insert_manuf_id')->default(0)->unsigned();
            $table->date('manuf_date')->nullable();
            $table->date('install_date')->nullable();
            $table->date('remove_date')->nullable();
            $table->float('lfs')->default('0.0');
            $table->float('mfs')->default('0.0');
            $table->float('sfs')->default('0.0');
            $table->text('notes')->nullable();
            $table->string('tube_status', 20)->default('Active');
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
        Schema::drop('tubes');
    }
}
