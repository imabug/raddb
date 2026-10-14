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
        Schema::create('gendata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tube_id')
                ->comment('Foreign key to tubes table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'tubes')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->tinyInteger('kv_set')->nullable()->unsigned();
            $table->float('ma_set')->nullable();
            $table->float('time_set')->nullable();
            $table->float('mas_set')->nullable();
            $table->float('add_filt')->nullable();
            $table->float('distance')->nullable();
            $table->float('kv_avg')->nullable();
            $table->float('kv_max')->nullable();
            $table->float('kv_eff')->nullable();
            $table->float('exp_time')->nullable();
            $table->float('exposure')->nullable();
            $table->float('dose_rate')
                ->nullable()
                ->comment('Dose rate (mGy/s)');
            $table->float('tot_filt')
                ->nullable()
                ->comment('Total filtration (mm Al)');
            $table->float('hvl')
                ->nullable()
                ->comment('Half value layer (mm Al)');
            $table->tinyInteger('use_flags')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('hvldata', function (Blueprint $table) {
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
            $table->float('kv')->nullable();
            $table->float('hvl')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('radsurveydata', function (Blueprint $table) {
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
            $table->float('sid_accuracy_error')->nullable();
            $table->float('avg_illumination')->nullable();
            $table->float('beam_alignment_error')->nullable();
            $table->float('rad_film_center_table')->nullable();
            $table->float('rad_film_center_wall')->nullable();
            $table->float('lfs_resolution')->nullable();
            $table->float('sfs_resolution')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collimatordata', function (Blueprint $table) {
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
            $table->enum('receptor', ['None', 'Table', 'Wall'])->default('None');
            $table->float('sid')->nullable();
            $table->float('indicated_trans')->nullable();
            $table->float('indicated_long')->nullable();
            $table->float('rad_trans')->nullable();
            $table->float('rad_long')->nullable();
            $table->float('light_trans')->nullable();
            $table->float('light_long')->nullable();
            $table->float('pbl_cass_trans')->nullable();
            $table->float('pbl_cass_long')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('radoutputdata', function (Blueprint $table) {
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
            $table->enum('focus', ['Large', 'Small'])->default('Large');
            $table->float('kv')->nullable();
            $table->float('output')->nullable();
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
        Schema::dropIfExists('gendata');
        Schema::dropIfExists('hvldata');
        Schema::dropIfExists('radsurveydata');
        Schema::dropIfExists('collimatordata');
        Schema::dropIfExists('radoutputdata');
    }
}
