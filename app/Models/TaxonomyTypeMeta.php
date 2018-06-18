<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\TaxonomyTypeMetaTransformer;

class TaxonomyTypeMeta extends Model
{
    public $transformer = TaxonomyTypeMetaTransformer::class;
    
    protected $fillable = ['name', 'taxonomy_type_id', 'is_mandatory'];

    public $timestamps = false;

    /**
     * Gets the taxonomy type associated with this meta
     */
    public function taxonomy_type() {
        return $this->belongsTo(TaxonomyType::class);
    }

    /**
     * Gets the taxonomy meta type values for the category type meta
     */
    public function taxonomy_type_meta_value() {
        return $this->hasMany(TaxonomyTypeMetaValue::class);
    }
}
