<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Manufacturer::class, function (Faker $faker) {
    return [
        'name'        => $faker->firstName(),
        'description' => $faker->paragraph(1),
        'address'     => $faker->address,
        'country'     => $faker->country,
        'region'      => $faker->state,
        'telephone'   => $faker->phoneNumber,
        'created_at'  => $faker->dateTimeThisDecade,
        'updated_at'  => $faker->dateTimeThisDecade,
    ];

});
