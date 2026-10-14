<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mamhvl', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('target_filter', 6);
            $table->tinyInteger('kv')->unsigned();
            $table->float('hvl')->comment('mm Al');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mamkvoutput', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('target_filter', 6);
            $table->tinyInteger('kv_set')->unsigned();
            $table->float('kv_meas');
            $table->float('output')->comment('mGy/mAs');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mamsurveydata', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('target_filter', 6);
            $table->float('avg_illumination')->nullable();
            $table->float('mgd_2d')->nullable();
            $table->float('mgd_3d')->nullable();
            $table->float('mgd_combo')->nullable();
            $table->float('cnr')->nullable();
            $table->float('snr')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mamresolution', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('target_filter', 6);
            $table->enum('mode', ['2D', '3D'])->default('2D');
            $table->enum('fs_size', ['Large', 'Small'])->default('Large');
            $table->tinyInteger('kv');
            $table->float('resolution')->comment('lp/mm');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mamlinearity', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('target_filter', 6);
            $table->smallInteger('mAs')->unsigned();
            $table->float('output')->comment('mGy/mAs');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mamacrphantom', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable()
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable()
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->enum('mode', ['2D', '3D', 'Mag', 'Film'])->default('2D');
            $table->enum('fibers', [1, 2, 3, 4, 5]);
            $table->enum('specks', [1, 2, 3, 4, 5]);
            $table->enum('masses', [1, 2, 3, 4, 5]);
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
        Schema::dropIfExists('mamhvl');
        Schema::dropIfExists('mamkvoutput');
        Schema::dropIfExists('mamsurveydata');
        Schema::dropIfExists('mamresolution');
        Schema::dropIfExists('mamlinearity');
        Schema::dropIfExists('mamacrphantom');
    }
}
