<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(RadDB\CTDailyQCRecord::class, function (Faker $faker) {
    return [
        'machine_id' => '130',
        'qcdate' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'scan_type' => $faker->randomElement(['Axial', 'Helical']),
        'water_hu' => $faker->randomFloat(1, -10, 10),
        'water_sd' => $faker->randomFloat(1, 0, 10),
        'artifacts' => $faker->randomElement(['Y', 'N']),
        'initials' => 'EM',
        'notes' => $faker->sentence(),
    ];
});
