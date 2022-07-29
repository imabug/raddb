<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gendata', function (Blueprint $table) {
            $table->float('dose_rate')
                ->nullable()
                ->comment('Dose rate (mGy/s)');
            $table->float('tot_filt')
                ->nullable()
                ->comment('Total filtration (mm Al)');
            $table->float('hvl')
                ->nullable()
                ->comment('Half value layer (mm Al)');
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
};
