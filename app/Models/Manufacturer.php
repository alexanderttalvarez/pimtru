<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ManufacturerTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use SoftDeletes;

    public $transformer = ManufacturerTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'address',
        'country',
        'region',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
