<?php

use App\Models\Machine;
use App\Models\Manufacturer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tubes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('housing_manuf_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable()
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('housing_model', 50)->nullable()->index();
            $table->string('housing_sn', 20)->nullable()->index();
            $table->foreignId('insert_manuf_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable()
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('insert_model', 50)->nullable()->index();
            $table->string('insert_sn', 20)->nullable()->index();
            $table->date('manuf_date')->nullable()->index();
            $table->date('install_date')->nullable()->index();
            $table->date('remove_date')->nullable()->index();
            $table->float('lfs')->default('0.0');
            $table->float('mfs')->default('0.0');
            $table->float('sfs')->default('0.0');
            $table->text('notes')->nullable()->fulltext();
            $table->string('tube_status', 20)->default('Active');
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
        Schema::drop('tubes');
    }
}
