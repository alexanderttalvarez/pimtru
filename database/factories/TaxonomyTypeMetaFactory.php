<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TaxonomyTypeMeta::class, function (Faker $faker) {
    return [
        'name'             => $faker->word,
        'taxonomy_type_id' => App\Models\TaxonomyType::all()->random()->id,
        'is_mandatory'     => $faker->boolean
    ];
});
