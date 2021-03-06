<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Goods;
use Faker\Generator as Faker;

$factory->define(Goods::class, function (Faker $faker) {
    return [
        'kd_brg'=> "B".$faker->unixTime,
        'nm_brg'=> $faker->text($maxNbChars = 30),
        'unit'  => $faker->randomElement($array = ['PCS', 'KG', 'Meter', 'Roll']),
        'harga' => $faker->randomNumber(6),
        'stock' => $faker->randomNumber(2),
    ];
});
