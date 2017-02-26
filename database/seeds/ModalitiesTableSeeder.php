<?php

use Illuminate\Database\Seeder;

class ModalitiesTableSeeder extends Seeder
{
    /**
     * Seed the modalities table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modalities')->insert([
            ['modality' => 'Angiography'],
            ['modality' => 'Bone Density'],
            ['modality' => 'C-Arm'],
            ['modality' => 'Cath Lab'],
            ['modality' => 'CR Reader'],
            ['modality' => 'CR Workstation'],
            ['modality' => 'CT'],
            ['modality' => 'Dental'],
            ['modality' => 'Fluoroscopy'],
            ['modality' => 'Mammography'],
            ['modality' => 'Mammography Workstation'],
            ['modality' => 'MRI'],
            ['modality' => 'Nuclear Medicine'],
            ['modality' => 'Portable'],
            ['modality' => 'Printer'],
            ['modality' => 'Rad/Fluoro'],
            ['modality' => 'Radiography'],
            ['modality' => 'Stereotactic Breast Biopsy'],
            ['modality' => 'Test Equipment'],
            ['modality' => 'Ultrasound'],
        ]);
    }
}
