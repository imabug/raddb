<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->nullable()->unsigned();
            $table->date('test_date')->nullable();
            $table->date('report_sent_date')->nullable();
            $table->integer('tester1_id')->default(0)->unsigned();
            $table->integer('tester2_id')->default(0)->unsigned();
            $table->integer('type_id')->default(0)->unsigned();
            $table->text('notes')->nullable();
            $table->integer('accession')->default(0)->unsigned();
            $table->text('report_file_path');
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
        Schema::drop('testdates');
    }
}
