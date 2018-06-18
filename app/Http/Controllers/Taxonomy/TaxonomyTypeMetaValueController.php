<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\TaxonomyTypeMetaValue;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\TaxonomyTypeMetaValueTransformer;
use App\Http\Requests\Taxonomy\StoreTaxonomyTypeMetaValueRequest;
use App\Http\Requests\Taxonomy\UpdateTaxonomyTypeMetaValueRequest;

class TaxonomyTypeMetaValueController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware(
            'transform.input:' . TaxonomyTypeMetaValueTransformer::class
        )->only(
            [
                'store',
                'update'
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TaxonomyTypeMetaValueValues = TaxonomyTypeMetaValue::all();

        return $this->showAll(
            $TaxonomyTypeMetaValueValues
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The data to be validated and inserted
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxonomyTypeMetaValueRequest $request)
    {
        $TaxonomyTypeMetaValue = TaxonomyTypeMetaValue::create($request->all());

        return $this->showOne($TaxonomyTypeMetaValue, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TaxonomyTypeMetaValue $TaxonomyTypeMetaValue The collection to show
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(TaxonomyTypeMetaValue $TaxonomyTypeMetaValue)
    {
        return $this->showOne($TaxonomyTypeMetaValue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\UpdateTaxonomyTypeMetaValueRequest $request The rules to validate data
     * @param \App\TaxonomyTypeMetaValue                          $TaxonomyTypeMetaValue The collection to update
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateTaxonomyTypeMetaValueRequest $request,
        TaxonomyTypeMetaValue $TaxonomyTypeMetaValue
    ) {
        $TaxonomyTypeMetaValue->fill(
            $request->only(
                [
                    'name',
                    'taxonomy_type_id',
                    'is_mandatory',
                ]
            )
        );

        if ($TaxonomyTypeMetaValue->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $TaxonomyTypeMetaValue->save();

        return $this->showOne($TaxonomyTypeMetaValue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TaxonomyTypeMetaValue $TaxonomyTypeMetaValue The colletion to destroy
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxonomyTypeMetaValue $TaxonomyTypeMetaValue)
    {
        $TaxonomyTypeMetaValue->delete();

        return $this->showOne($TaxonomyTypeMetaValue);
    }
}
