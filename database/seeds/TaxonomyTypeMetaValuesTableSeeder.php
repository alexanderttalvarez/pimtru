<?php

use Illuminate\Database\Seeder;

class TaxonomyTypeMetaValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_type_meta_values = factory(App\Models\TaxonomyTypeMetaValue::class)
            ->times(4)
            ->create();
    }
}
