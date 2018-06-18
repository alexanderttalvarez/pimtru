<?php

namespace App\Models;

use App\TaxonomyType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\TaxonomyTransformer;

class Taxonomy extends Model
{
    public $transformer = TaxonomyTransformer::class;

    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_id',
        'taxonomy_type_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    /**
     * It returns all the fillable fields of the model
     * @return array
     */
    public static function getFillableFields() {
        $self = new static;
        return $self->fillable;
    }

    /**
     * Get the Type associated with the Category
     */
    public function taxonomy_type() {
        return $this->belongsTo(TaxonomyType::class);
    }

    /**
     * Self referencing field for selecting parents
     */
    public function parent() {
        return $this->belongsTo('Taxonomy', 'parent_id');
    }

    public function children() {
        return $this->hasMany('Taxonomy', 'parent_id');
    }

    /**
     * Get the category meta values for the category
     */
    public function taxonomy_type_meta_value() {
        return $this->hasMany(TaxonomyTypeMetaValue::class);
    }

    public function product() {
        return $this->belongsToMany(Product::class);
    }

}
