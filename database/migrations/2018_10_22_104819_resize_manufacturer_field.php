<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResizeManufacturerField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Increase the size of the manufacturer field in the manufacturers table
        Schema::table('manufacturers', function (Blueprint $table) {
            $table->string('manufacturer', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Change size of manufacturer field back to 20 characters
        // Schema::table('manufacturers', function (Blueprint $table) {
        //     $table->string('manufacturer', 20)->change();
        // });
    }
}
