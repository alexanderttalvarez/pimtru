<?php
/**
 * Handles all the CRUD actions for taxonomies through the API
 *
 * PHP version 7.2.2
 *
 * @author "Alexander Torres <alexanderttalvarez@gmail.com>"
 * @since  1.0.0 Introduced from the beginning
 */
namespace App\Http\Controllers\Taxonomy;

use Illuminate\Http\Request;
use App\Models\TaxonomyType;
use App\Http\Controllers\ApiController;
use App\Transformers\TaxonomyTypeTransformer;
use App\Http\Requests\Taxonomy\StoreTaxonomyTypeRequest;
use App\Http\Requests\Taxonomy\UpdateTaxonomyTypeRequest;

class TaxonomyTypeController extends ApiController
{

    /**
     * Class construct.
     * It calls parent's construct, and apply a middleware for transforming
     * the returned array.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TaxonomyTypeTransformer::class)
            ->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxonomyTypes = TaxonomyType::all();

        return $this->showAll($taxonomyTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The rules for a valid request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxonomyTypeRequest $request)
    {
        $taxonomyType = TaxonomyType::create($request->all());

        return $this->showOne($taxonomyType, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TaxonomyType $taxonomyType The taxonomy type to show
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TaxonomyType $taxonomyType)
    {
        return $this->showOne($taxonomyType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request      The rules for the validation of
     *                                               the request
     * @param \App\TaxonomyType        $taxonomyType The taxonomy type to update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxonomyTypeRequest $request,
        TaxonomyType $taxonomyType
    ) {
        $taxonomyType->fill(
            $request->only(
                [
                    'name',
                    'description',
                    'hierarchical', 
                ]
            )
        );

        if ($taxonomyType->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $taxonomyType->save();

        return $this->showOne($taxonomyType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TaxonomyType $taxonomyType The taxonomy type to delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxonomyType $taxonomyType)
    {
        $taxonomyType->delete();

        return $this->showOne($taxonomyType);
    }
}
