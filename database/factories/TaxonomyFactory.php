<?php

use App\Models\Taxonomy;
use Faker\Generator as Faker;

$factory->define(App\Models\Taxonomy::class, function (Faker $faker) {

    // Checking if the name exists previously
    do {
        $foundName = false;

        $name = $faker->firstName();

        if (Taxonomy::where('name', '=', $name)->first() != null) {
            $foundName = true;
        }
    } while( $foundName == true );
    
    return [
        'name'             => $name,
        'description'      => $faker->realText(random_int(20,160)),
        'image'            => $faker->imageUrl(100,100,'abstract'),
        'taxonomy_type_id' => App\Models\TaxonomyType::all()->random()->id,
        'created_at'       => $faker->dateTimeThisDecade,
        'updated_at'       => $faker->dateTimeThisDecade
    ];
});