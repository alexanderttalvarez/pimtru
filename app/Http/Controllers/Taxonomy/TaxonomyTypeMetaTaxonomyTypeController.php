<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\TaxonomyTypeMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class TaxonomyTypeMetaTaxonomyTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     * 
     * @param App\Models\TaxonomyTypeMeta $taxonomyTypeMeta - Taxonomy type meta entity
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        $taxonomyTypes = $taxonomyTypeMeta->taxonomy_type;

        return $this->showOne($taxonomyTypes);
    }

}