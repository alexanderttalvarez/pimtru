<?php

namespace App\Models;

use App\Models\Taxonomy;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public $transformer = ProductTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'legal_text',
        'quantity_per_unit',
        'unit_name',
        'image',
        'storehouse_stock',
        'manufacturer_id',
        'discontinued'
    ];

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /**
     * @return boolean
     */
    public function isDiscontinued() {
        return $this->discontinued;
    }
    
    /**
     * Checks the stock and returns false if it's equal to 0
     * @return boolean
     */
    public function isAvailable() {
        return $this->storehouse_stock > 0;
    }

}
