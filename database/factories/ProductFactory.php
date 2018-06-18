<?php

use Faker\Generator as Faker;
use App\Models\Manufacturer;

$factory->define(App\Models\Product::class, function (Faker $faker) {

    $manufacturer = Manufacturer::all()->random();

    return [
        'name'              => $faker->firstName(),
        'description'       => $faker->paragraph(1),
        'price'             => $faker->randomFloat(2, 0, 200),
        'legal_text'        => $faker->realText(random_int(20,160)),
        'quantity_per_unit' => rand(1,6),
        'unit_name'         => $faker->word(),
        'image'             => $faker->imageUrl( 400, 400 ),
        'storehouse_stock'  => rand(0,500),
        'manufacturer_id'   => $manufacturer->id,
        'discontinued'      => $faker->boolean(),
        'created_at'        => $faker->dateTimeThisDecade,
        'updated_at'        => $faker->dateTimeThisDecade,
    ];
});
