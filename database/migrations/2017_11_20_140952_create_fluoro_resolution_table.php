<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluoroResolutionTable extends Migration
{
    /**
     * Table for Huttner Type 18 resolution pattern data.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluoro_resolution', function (Blueprint $table) {
            $table->increments('id');
            $table->float('field_size')->nullable();
            $table->float('resolution')->nullable()->comment('Resolution in lp/mm');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('fluoro_resolution');
    }
}
