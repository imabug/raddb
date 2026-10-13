<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('person', 50)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('pager', 6)->nullable();
            $table->string('email', 50)->nullable();
            $table->foreignId('location_id')
                ->comment('Foreign key to locations table')
                ->nullable()
                ->index()
                ->constrained(table: 'locations')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('title', 50)->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
