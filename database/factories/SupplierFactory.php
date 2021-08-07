<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'kd_supp'=> $faker->text($maxNbChars = 10),
        'nm_supp'=> $faker->text($maxNbChars = 50),
        'alamat' => $faker->address,
        'telpon' => $faker->e164PhoneNumber,
        'email' => $faker->email,
    ];
});
