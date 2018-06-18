<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\Taxonomy;
use App\Models\TaxonomyTypeMeta;
use App\Http\Controllers\Controller;
use App\Models\TaxonomyTypeMetaValue;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Taxonomy\UpdateTaxonomyTaxonomyTypeMetaRequest;

class TaxonomyTaxonomyTypeMetaController extends ApiController
{
    /**
     * Display the specified resource.
     *
     * @param \App\Taxonomy         $taxonomy         The taxonomy type to show
     * @param \App\TaxonomyTypeMeta $taxonomyTypeMeta The taxonomy type to update
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Taxonomy $taxonomy, TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        $taxonomyTypeMetaValue = TaxonomyTypeMetaValue::class;

        return $this->showOne(
            $taxonomyTypeMetaValue::all()
            ->where('taxonomy_id', $taxonomy->id)
            ->where('taxonomy_type_meta_id', $taxonomyTypeMeta->id)
            ->first()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\UpdateTaxonomyTaxonomyTypeMetaRequest $request          The rules for the validation of
     *                                                                                 the request
     * @param \App\Taxonomy                                          $taxonomy         The taxonomy type to show
     * @param \App\TaxonomyTypeMeta                                  $taxonomyTypeMeta The taxonomy type to update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxonomyTaxonomyTypeMetaRequest $request,
        Taxonomy $taxonomy,
        TaxonomyTypeMeta $taxonomyTypeMeta
    ) {
        
        $currentValue = self::findCurrentValue($taxonomy->id, $taxonomyTypeMeta->id);

        if ($currentValue == null) {
            return $this->errorResponse(
                sprintf(__('errors.instance_not_found'), 'taxonomyTypeMetaValue'),
                404
            );
        }
            
        $currentValue->fill(
            $request->only(
                [
                    'value',
                ]
            )
        );

        if ($currentValue->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $currentValue->save();

        return $this->showOne($currentValue);
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

    /**
     * It finds the current value of the taxonomy type meta
     * 
     * @param integer $taxonomy_id
     * @param integer $taxonomy_type_meta_id
     * 
     * @return TaxonomyTypeMetaValue
     */
    public static function findCurrentValue(
        $taxonomy_id,
        $taxonomy_type_meta_id
    )
    {

        $taxonomyTypeMetaValue = TaxonomyTypeMetaValue::class;

        $currentValue = $taxonomyTypeMetaValue::all()
            ->where('taxonomy_id', $taxonomy_id)
            ->where('taxonomy_type_meta_id', $taxonomy_type_meta_id)
            ->first();

        return $currentValue;

    }

}