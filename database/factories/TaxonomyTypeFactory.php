<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TaxonomyType::class, function (Faker $faker) {
    return [
        'name'         => $faker->lastName,
        'description'  => $faker->realText(random_int(20,160)),
        'hierarchical' => $faker->boolean,
        'has_image'    => $faker->boolean,
        'created_at'   => $faker->dateTimeThisDecade,
        'updated_at'   => $faker->dateTimeThisDecade
    ];
});
