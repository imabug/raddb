<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtdailyqcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctdailyqc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->unsigned()->nullable();
            $table->date('qcdate')->nullable();
            $table->enum('scan_type', ['Axial', 'Helical'])->nullable();
            $table->float('water_hu', 4, 1)->nullable();
            $table->float('water_sd', 4, 1)->nullable();
            $table->enum('artifacts', ['Y', 'N'])->nullable();
            $table->string('initials', 4);
            $table->text('notes')->nullable();
            $table->index(['machine_id', 'id']);
            $table->index('qcdate');
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
        Schema::dropIfExists('ctdailyqc');
    }
}
