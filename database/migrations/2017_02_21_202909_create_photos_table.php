<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('machine_id')->nullable();
            $table->string('photo_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::disableForeignKeyConstraints();

        // Add foreign keys to photos table
        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('machine_id')->references('id')->on('machines');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('photos');
        Schema::enableForeignKeyConstraints();
    }
}
