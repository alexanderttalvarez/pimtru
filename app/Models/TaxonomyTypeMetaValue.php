<?php

namespace App\Models;

use App\Models\TaxonomyType;
use App\Models\TaxonomyTypeMeta;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\TaxonomyTypeMetaValueTransformer;

class TaxonomyTypeMetaValue extends Model
{
    public $transformer = TaxonomyTypeMetaValueTransformer::class;

    protected $fillable = ['value', 'taxonomy_id', 'taxonomy_type_meta_id'];

    public $timestamps = false;

    /**
     * Gets the taxonomy type associated with this meta value
     */
    public function taxonomy()
    {
        return $this->belongsTo(TaxonomyType::class);
    }

    /**
     * Gets the taxonomy type meta associated with this meta value
     */
    public function taxonomy_type_meta()
    {
        return $this->belongsTo(TaxonomyTypeMeta::class);
    }
}
