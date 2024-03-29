<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CTQCDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RadDB\CTDailyQCRecord::class, 300)->create();
    }
}
