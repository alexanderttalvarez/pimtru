<?php

namespace App\Transformers;

use App\Models\TaxonomyTypeMeta;
use League\Fractal\TransformerAbstract;

class TaxonomyTypeMetaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TaxonomyTypeMeta $taxonomyTypeMeta)
    {
        return [
            'id'             => $taxonomyTypeMeta->id,
            'name'           => $taxonomyTypeMeta->name,
            'taxonomyTypeId' => $taxonomyTypeMeta->taxonomy_type_id,
            'isMandatory'    => $taxonomyTypeMeta->is_mandatory,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('taxonomyTypeMetas.show', $taxonomyTypeMeta->id)
                ],
                [
                    'rel' => 'taxonomyTypeMetas.taxonomyTypes',
                    'href' => route('taxonomyTypeMetas.taxonomyType.index', $taxonomyTypeMeta->id)
                ],
                [
                    'rel' => 'taxonomyTypeMetas.taxonomyTypeMetaValues',
                    'href' => route('taxonomyTypeMetas.taxonomyTypeMetaValues.index', $taxonomyTypeMeta->id)
                ],
            ]
        ];

    }

    /**
     * It stablish a relation between the transformed name and the original attribute
     * 
     * @return array
     */
    public static function originalAttribute($index) {
        $attributes = [
            'id'             => 'id',
            'name'           => 'name',
            'taxonomyTypeId' => 'taxonomy_type_id',
            'isMandatory'    => 'is_mandatory',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * It returns which one is the original attribute
     * 
     * @return array
     */
    public static function transformedAttribute($index) {
        $attributes = [
            'id'               => 'id',
            'name'             => 'name',
            'taxonomy_type_id' => 'taxonomyTypeId',
            'is_mandatory'     => 'isMandatory',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
