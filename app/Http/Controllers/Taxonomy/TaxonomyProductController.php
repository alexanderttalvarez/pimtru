<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\Taxonomy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class TaxonomyProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     * 
     * @param App\Models\Taxonomy $taxonomy - Taxonomy entity
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Taxonomy $taxonomy)
    {
        $products = $taxonomy->product;

        return $this->showAll($products);
    }

}