<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDescModelSizeInMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->string('model', 100)->change();
            $table->string('description', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Change field sizes back to what they were before
        Schema::table('machines', function (Blueprint $table) {
            $table->string('model', 50)->change();
            $table->string('description', 60)->change();
        });
    }
}
