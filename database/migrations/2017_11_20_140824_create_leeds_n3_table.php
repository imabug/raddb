<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeedsN3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leeds_n3', function (Blueprint $table) {
            $table->increments('id');
            $table->float('field_size')->nullable();
            $table->float('n3')->nullable()->comment('Leeds N3 low contrast');
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
        Schema::dropIfExists('leeds_n3');
    }
}
