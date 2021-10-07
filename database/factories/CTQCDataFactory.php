<?php

namespace Database\Factories;

use Faker\Generator as Faker;

/*
 * Model factory to generate random CT QC data.
 * A random date within the most recent three months is used for the QC date.
 */

$factory->define(RadDB\CTDailyQCRecord::class, function (Faker $faker) {
    return [
        'machine_id' => '130',
        'qcdate'     => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        'scan_type'  => $faker->randomElement(['Axial', 'Helical']),
        'water_hu'   => $faker->randomFloat(1, -15, 15),
        'water_sd'   => $faker->randomFloat(1, 0, 10),
        'artifacts'  => $faker->randomElement(['Y', 'N']),
        'initials'   => 'EM',
        'notes'      => $faker->sentence(),
    ];
});
