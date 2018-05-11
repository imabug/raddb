<?php

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
        factory(RadDB\CTDailyQCRecord::class, 100)->create();
    }
}
