<?php

use App\Models\Machine;
use App\Models\TestType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testdates', function (Blueprint $table) {
            $table->id();
            $table->integer('machine_id')
                ->foreignIdFor(Machine::class)->index();
            $table->date('test_date')->nullable();
            $table->date('report_sent_date')->nullable();
            $table->integer('tester1_id')->default(0)->unsigned();
            $table->integer('tester2_id')->nullable()->unsigned();
            $table->integer('type_id')
                ->foreignIdFor(TestType::class)->index();
            $table->text('notes')->nullable();
            $table->string('accession')->nullable();
            $table->text('report_file_path')->nullable();
            $table->integer('survey_report_id')->nullable();
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
        Schema::drop('testdates');
    }
}
