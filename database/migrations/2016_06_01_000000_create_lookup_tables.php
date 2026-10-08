<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('modalities', function (Blueprint $table) {
            $table->id();
            $table->string('modality', 25)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('testtypes', function (Blueprint $table) {
            $table->id();
            $table->string('test_type', 30)->nullable();
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
        Schema::drop('locations');
    }
}
