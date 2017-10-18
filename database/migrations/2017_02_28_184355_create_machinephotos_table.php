<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinephotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinephotos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->unsigned()->default(0);
            $table->text('machine_photo_path')->nullable();
            $table->text('machine_photo_thumb')->nullable();
            $table->text('photo_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // $table->foreign('machine_id')->references('id')->on('machines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machinephotos');
    }
}
