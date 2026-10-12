->default(0)<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineSurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_surveydata', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->boolean('gendata')->default(0);
            $table->boolean('collimatordata')->default(0);
            $table->boolean('radoutputdata')->default(0);
            $table->boolean('radsurveydata')->default(0);
            $table->boolean('hvldata')->default(0);
            $table->boolean('fluorodata_1')->default(0);
            $table->boolean('maxfluorodata_1')->default(0);
            $table->boolean('receptorentrance_1')->default(0);
            $table->boolean('fluorodata_2')->default(0);
            $table->boolean('maxfluorodata_2')->default(0);
            $table->boolean('receptorentrance_2')->default(0);
            $table->boolean('leeds_n3')->nullable()->default(null);
            $table->boolean('leeds_to10')->nullable()->default(null);
            $table->boolean('fluoro_resolution')->nullable()->default(null);
            $table->boolean('mamhvl')
                ->default(0)
                ->comment('Mammo HVL');
            $table->boolean('mamkvoutput')
                ->default(0)
                ->comment('Mammo kV accuracy/output');
            $table->boolean('mamsurveydata')
                ->default(0)
                ->comment('Mammo light field, MGD, SNR/CNR');
            $table->boolean('mamresolution')
                ->default(0)
                ->comment('Mammo resolution');
            $table->boolean('mamlinearity')
                ->default(0)
                ->comment('Mammo output linearity');
            $table->boolean('mamacrphantom')
                ->default(0)
                ->comment('Mammo ACR phantom');
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
        //
    }
}
