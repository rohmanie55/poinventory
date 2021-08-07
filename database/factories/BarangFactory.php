<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Barang;
use Faker\Generator as Faker;

$factory->define(Barang::class, function (Faker $faker) {
    return [
        'kd_brg'=> $faker->text($maxNbChars = 10),
        'nm_brg'   => $faker->text($maxNbChars = 50),
        'unit'     => $faker->randomElement($array = ['PCS', 'KG', 'Meter']),
        'harga' => $faker->randomNumber(6),
        'stock' => $faker->randomNumber(2),
    ];
});
