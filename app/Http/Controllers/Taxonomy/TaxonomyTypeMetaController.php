<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\TaxonomyTypeMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\TaxonomyTypeMetaTransformer;
use App\Http\Requests\Taxonomy\StoreTaxonomyTypeMetaRequest;
use App\Http\Requests\Taxonomy\UpdateTaxonomyTypeMetaRequest;

class TaxonomyTypeMetaController extends ApiController
{

    public function __construct() {
        parent::__construct();

        $this->middleware('transform.input:' . TaxonomyTypeMetaTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxonomyTypeMetas = TaxonomyTypeMeta::all();

        return $this->showAll(
            $taxonomyTypeMetas
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The data to be validated and inserted
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxonomyTypeMetaRequest $request)
    {
        $taxonomyTypeMeta = TaxonomyTypeMeta::create($request->all());

        return $this->showOne($taxonomyTypeMeta, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TaxonomyTypeMeta $taxonomyTypeMeta The collection to show
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        return $this->showOne($taxonomyTypeMeta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request          The rules to validate data
     * @param \App\TaxonomyTypeMeta    $taxonomyTypeMeta The collection to update
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxonomyTypeMetaRequest $request, TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        $taxonomyTypeMeta->fill(
            $request->only(
                [
                    'name',
                    'taxonomy_type_id',
                    'is_mandatory',
                ]
            )
        );

        if ($taxonomyTypeMeta->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $taxonomyTypeMeta->save();

        return $this->showOne($taxonomyTypeMeta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TaxonomyTypeMeta $taxonomyTypeMeta The colletion to destroy
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        $taxonomyTypeMeta->delete();

        return $this->showOne($taxonomyTypeMeta);
    }
}
