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
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('test_type_id')
                ->comment('Foreign key to testtypes table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'test_types')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('tester1_id')
                ->comment('Foreign key to testers table')
                ->default(0)
                ->constrained(table: 'testers')
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->foreignId('tester2_id')
                ->comment('Foreign key to testers table')
                ->nullable()
                ->index()
                ->constrained(table: 'testesr')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->date('test_date')->nullable(false)->index();
            $table->date('report_sent_date')->nullable();
            $table->text('notes')->nullable()->fulltext();
            $table->string('accession')->nullable()->index();
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
        Schema::dropIfExists('testdates');
    }
}
