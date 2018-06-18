<?php

use Illuminate\Database\Seeder;

class TaxonomiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxonomies = factory(App\Models\Taxonomy::class)
            ->times(30)
            ->create();
    }
}
