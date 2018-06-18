<?php

use Illuminate\Database\Seeder;

class TaxonomyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_types = factory(App\Models\TaxonomyType::class)
            ->times(4)
            ->create();

    }
}
