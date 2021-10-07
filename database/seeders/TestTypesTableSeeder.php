<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestTypesTableSeeder extends Seeder
{
    /**
     * Seed the testtypes table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modalities')->insert([
            ['test_type' => 'Routine compliance'],
            ['test_type' => 'Acceptance'],
            ['test_type' => 'Major service check'],
            ['test_type' => 'Follow up'],
            ['test_type' => 'Phantom review'],
            ['test_type' => 'Shielding survey'],
            ['test_type' => 'Bone densitometer survey'],
            ['test_type' => 'Other'],
            ['test_type' => 'Accreditation survey'],
            ['test_type' => 'Calibration'],
            ['test_type' => 'Shielding plan'],
        ]);
    }
}
