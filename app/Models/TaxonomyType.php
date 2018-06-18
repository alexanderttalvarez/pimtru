<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\TaxonomyTypeTransformer;

class TaxonomyType extends Model
{
    public $transformer = TaxonomyTypeTransformer::class;

    protected $fillable = [
        'name',
        'description',
        'hierarchical',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the categories for the taxonomy type
     */
    public function taxonomy() {
        return $this->hasMany(Taxonomy::class);
    }

    /**
     * Get the category metas for the category
     */
    public function taxonomy_type_meta() {
        return $this->hasMany(TaxonomyTypeMeta::class);
    }
}
