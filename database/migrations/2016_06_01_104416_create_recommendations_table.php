<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->default(0)->unsigned();
            $table->text('recommendation');
            $table->tinyInteger('resolved')->default(0);
            $table->dateTime('rec_add_ts')->nullable();
            $table->dateTime('rec_resolve_ts')->nullable();
            $table->date('rec_resolve_date')->nullable();
            $table->string('resolved_by', 40);
            $table->string('rec_status', 40)->default('New');
            $table->string('wo_number', 50);
            $table->text('service_report_path')->nullable();
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
        Schema::drop('recommendations');
    }
}
