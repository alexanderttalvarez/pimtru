<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TaxonomyTypeMetaValue::class, function (Faker $faker) {
    return [
        'value'                 => $faker->word,
        'taxonomy_id'           => App\Models\Taxonomy::all()->unique()->random()->id,
        'taxonomy_type_meta_id' => App\Models\TaxonomyTypeMeta::all()->random()->id,
    ];
});
