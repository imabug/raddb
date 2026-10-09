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
            $table->integer('modality_id')
                ->foreignIdFor(Modality::class)->index();
            $table->integer('manufacturer_id')
                ->foreignIdFor(Manufacturer::class)->index();
            $table->integer('location_id')
                ->foreignIdFor(Location::class)->index();
            $table->string('description')->nullable();
            $table->string('vend_site_id', 25)->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number', 20)->nullable();
            $table->date('manuf_date')->nullable();
            $table->date('install_date')->nullable();
            $table->date('remove_date')->nullable();
            $table->string('room', 20)->nullable();
            $table->string('machine_status', 50)->default('Active');
            $table->text('notes')->nullable();
            $table->string('photo')->nullable()->comment('Deprecated');
            $table->string('software_version')->nullable();
            $table->string('pacs_station')->nullable();
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
    }
}
