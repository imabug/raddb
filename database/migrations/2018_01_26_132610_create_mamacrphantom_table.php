<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMamacrphantomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mamacrphantom', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->integer('machine_id')->unsigned();
            $table->integer('tube_id')->unsigned()->nullable();
            $table->enum('mode', ['2D', '3D', 'Mag', 'Film'])->default('2D');
            $table->enum('fibers', [1, 2, 3, 4, 5]);
            $table->enum('specks', [1, 2, 3, 4, 5]);
            $table->enum('masses', [1, 2, 3, 4, 5]);
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
        Schema::dropIfExists('mamacrphantom');
    }
}
