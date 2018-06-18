<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\TaxonomyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class TaxonomyTypeTaxonomyController extends ApiController
{
    /**
     * Display a listing of the resource.
     * 
     * @param App\Models\TaxonomyType $taxonomyType - Taxonomy type entity
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaxonomyType $taxonomyType)
    {
        $taxonomies = $taxonomyType->taxonomy;

        return $this->showAll($taxonomies);
    }

}