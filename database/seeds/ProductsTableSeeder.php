<?php

use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    private $amountProducts = 50;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = factory(App\Models\Product::class)
            ->times( $this->amountProducts )
            ->create()
            ->each(
                function ($product) {
                    $taxonomies = Taxonomy::all()->random(mt_rand(1, 5))->pluck('id');
                    $product->taxonomies()->attach($taxonomies);
                }
            );
    }
}
