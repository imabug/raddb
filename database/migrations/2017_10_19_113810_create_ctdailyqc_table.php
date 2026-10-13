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
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->date('qcdate')->nullable()->index();
            $table->enum('scan_type', ['Axial', 'Helical'])->nullable();
            $table->float('water_hu')->nullable();
            $table->float('water_sd')->nullable();
            $table->enum('artifacts', ['Y', 'N'])->nullable();
            $table->string('initials', 4);
            $table->text('notes')->nullable();
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
