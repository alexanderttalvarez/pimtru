<?php

use Illuminate\Database\Seeder;

class TaxonomyTypeMetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxonomy_type_metas = factory(App\Models\TaxonomyTypeMeta::class)
            ->times(4)
            ->create();
    }
}
