<?php

namespace App\Transformers;

use App\Models\TaxonomyTypeMetaValue;
use League\Fractal\TransformerAbstract;

class TaxonomyTypeMetaValueTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TaxonomyTypeMetaValue $taxonomyTypeMetaValue)
    {
        return [
            'taxonomyId'         => $taxonomyTypeMetaValue->taxonomy_id,
            'taxonomyTypeMetaId' => $taxonomyTypeMetaValue->taxonomy_type_meta_id,
            'value'              => $taxonomyTypeMetaValue->value,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route(
                        'taxonomies.taxonomyTypeMetas.show',
                        [
                            $taxonomyTypeMetaValue->taxonomy_id, // Taxonomy ID
                            $taxonomyTypeMetaValue->taxonomy_type_meta_id // Taxonomy type meta ID
                        ]
                    )
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
            'taxonomyId'         => 'taxonomy_id',
            'taxonomyTypeMetaId' => 'taxonomy_type_meta_id',
            'value'              => 'value',
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
            'taxonomy_id' => 'taxonomyId',
            'taxonomy_type_meta_id' => 'taxonomyTypeMetaId',
            'value' => 'value',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
