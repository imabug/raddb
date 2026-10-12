<?php

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                ->comment('Foreign key to locations table')
                ->nullable()
                ->index()
                ->constrained(table: 'locations')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('modality_id')
                ->commment('Foreign key to modalities table')
                ->nullable()
                ->index()
                ->constrained(table: 'modalities')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('manufacturer_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable()
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('description')->nullable()->index();
            $table->string('vend_site_id', 25)->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('serial_number', 20)->nullable()->index();
            $table->date('manuf_date')->nullable()->index();
            $table->date('install_date')->nullable()->index();
            $table->date('remove_date')->nullable()->index();
            $table->string('room', 20)->nullable();
            $table->string('machine_status', 50)->default('Active');
            $table->text('notes')->nullable();
            $table->string('photo')->nullable()->comment('Deprecated');
            $table->string('software_version')->nullable();
            $table->string('pacs_station')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('opnotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->text('note')->nullable();
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
        Schema::drop('machines');
        Schema::dropIfExists('opnotes');
    }
}
