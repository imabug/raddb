<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMammoFieldsToMachineSurveydataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machine_surveydata', function (Blueprint $table) {
            $table->boolean('mamhvl')
                ->default(0)
                ->after('fluoro_resolution')
                ->comment('Mammo HVL');
            $table->boolean('mamkvoutput')
                ->default(0)
                ->after('mamhvl')
                ->comment('Mammo kV accuracy/output');
            $table->boolean('mamsurveydata')
                ->default(0)
                ->after('mamkvoutput')
                ->comment('Mammo light field, MGD, SNR/CNR');
            $table->boolean('mamresolution')
                ->default(0)
                ->after('mamsurveydata')
                ->comment('Mammo resolution');
            $table->boolean('mamlinearity')
                ->default(0)
                ->after('mamresolution')
                ->comment('Mammo output linearity');
            $table->boolean('mamacrphantom')
                ->default(0)
                ->after('mamlinearity')
                ->comment('Mammo ACR phantom');
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
