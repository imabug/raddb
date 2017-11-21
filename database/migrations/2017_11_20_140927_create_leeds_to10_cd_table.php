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
            $table->integer('survey_id')->unsigned()->nullable()->default(null);
            $table->integer('machine_id')->unsigned()->nullable()->default(null);
            $table->integer('tube_id')->unsigned()->nullable()->default(null);
            $table->float('field_size')->nullable()->default(null);
            $table->float('A')->nullable()->default(null);
            $table->float('B')->nullable()->default(null);
            $table->float('C')->nullable()->default(null);
            $table->float('D')->nullable()->default(null);
            $table->float('E')->nullable()->default(null);
            $table->float('F')->nullable()->default(null);
            $table->float('G')->nullable()->default(null);
            $table->float('H')->nullable()->default(null);
            $table->float('J')->nullable()->default(null);
            $table->float('K')->nullable()->default(null);
            $table->float('L')->nullable()->default(null);
            $table->float('M')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
            $table->index('field_size');
            $table->index('survey_id');
            $table->index('machine_id');
            $table->index('tube_id');
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
