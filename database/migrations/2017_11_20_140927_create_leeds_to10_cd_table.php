<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeedsTo10CdTable extends Migration
{
    /**
     * Table for Leeds TO.10 contrast detail data.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leeds_to10_cd', function (Blueprint $table) {
            $table->increments('id');
            $table->float('field_size')->nullable();
            $table->float('A')->nullable();
            $table->float('B')->nullable();
            $table->float('C')->nullable();
            $table->float('D')->nullable();
            $table->float('E')->nullable();
            $table->float('F')->nullable();
            $table->float('G')->nullable();
            $table->float('H')->nullable();
            $table->float('J')->nullable();
            $table->float('K')->nullable();
            $table->float('L')->nullable();
            $table->float('M')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('field_size');
        });
        DB::statement("ALTER TABLE `leeds_to10_cd` comment 'Leeds TO.10 low contrast detail'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leeds_to10_cd');
    }
}
