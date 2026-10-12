<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFluoroDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluorodata', function (Blueprint $table) {
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
            $table->float('field_size')->nullable();
            $table->float('atten')->nullable();
            $table->string('dose1_mode', 50)->nullable();
            $table->float('dose1_kv')->nullable();
            $table->float('dose1_ma')->nullable();
            $table->float('dose1_rate')->nullable();
            $table->string('dose2_mode', 50)->nullable();
            $table->float('dose2_kv')->nullable();
            $table->float('dose2_ma')->nullable();
            $table->float('dose2_rate')->nullable();
            $table->string('dose3_mode', 50)->nullable();
            $table->float('dose3_kv')->nullable();
            $table->float('dose3_ma')->nullable();
            $table->float('dose3_rate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('maxfluorodata', function (Blueprint $table) {
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
            $table->float('dose1_kv')->nullable();
            $table->float('dose1_ma')->nullable();
            $table->float('dose1_rate')->nullable();
            $table->float('dose2_kv')->nullable();
            $table->float('dose2_ma')->nullable();
            $table->float('dose2_rate')->nullable();
            $table->float('dose3_kv')->nullable();
            $table->float('dose3_ma')->nullable();
            $table->float('dose3_rate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('receptorentrance', function (Blueprint $table) {
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
            $table->float('field_size')->nullable();
            $table->string('mode', 50)->nullable();
            $table->float('kv')->nullable();
            $table->float('ma')->nullable();
            $table->float('rate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fluoro_resolution', function (Blueprint $table) {
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
            $table->float('field_size')->nullable()->default(null)->index();
            $table->float('resolution')->nullable()->default(null)->comment('Resolution in lp/mm');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('leeds_n3', function (Blueprint $table) {
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
            $table->float('field_size')->nullable()->default(null)->index();
            $table->float('n3')->nullable()->default(null)->comment('Leeds N3 low contrast');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('leeds_to10', function (Blueprint $table) {
            $table->id();
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
            $table->float('field_size')->unsigned()->nullable()->default(null)->index();
            $table->char('to10_row', 1)->nullable()->default(null);
            $table->float('cd')->unsigned()->nullable()->default(null)->comment('Contrast detail');
            $table->float('ti')->unsigned()->nullable()->default(null)->comment('Threshold index');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('leeds_to10_cd', function (Blueprint $table) {
            $table->comment('Leeds TO.10 low contrast detail');
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
            $table->float('field_size')->nullable()->default(null)->index();
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
        });

        Schema::create('leeds_to10_ti', function (Blueprint $table) {
            $table->comment('Leeds TO.10 low contrast threshold index');
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
            $table->float('field_size')->nullable()->default(null)->index();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fluorodata');
        Schema::dropIfExists('maxfluorodata');
        Schema::dropIfExists('receptorentrace');
        Schema::dropIfExists('fluoro_resolutino');
        Schema::dropIfExists('leeds_n3');
        Schema::dropIfExists('leeds_to10');
        Schema::dropIfExists('leeds_to10_ti');
        Schema::dropIfExists('leeds_to10_cd');
    }
}
