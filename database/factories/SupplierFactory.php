<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'kd_supp'=> "S".$faker->unixTime,
        'nama'=> $faker->company,
        'alamat' => $faker->address,
        'telpon' => $faker->e164PhoneNumber,
        'email' => $faker->email,
    ];
});
