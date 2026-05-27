<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         * Table to manage shielding plan requests
         */
        Schema::create('shielding_requests', function (Blueprint $table) {
            $table->id();
            $table->tinyText('description')
                ->nullable(false);
            $table->date('request_date')
                ->nullable(false)
                ->index();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable()
                ->index();
            $table->foreignId('user_id')
                ->comment('Foreign key to users table')
                ->nullable(false)
                ->index();
            $table->string('status', 20)
                ->nullable(false)
                ->index();
            $table->date('completion_date')
                ->nullable()
                ->index();
            $table->text('notes')->nullable()->fullText();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
