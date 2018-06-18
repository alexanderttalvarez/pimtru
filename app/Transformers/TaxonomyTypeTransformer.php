<?php

namespace App\Transformers;

use App\Models\TaxonomyType;
use App\Models\TaxonomyTypeMeta;
use League\Fractal\TransformerAbstract;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class TaxonomyTypeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TaxonomyType $taxonomyType)
    {
        
        $taxonomyTypeTransformed = [
            'id'             => $taxonomyType->id,
            'name'           => $taxonomyType->name,
            'description'    => $taxonomyType->description,
            'hierarchical'   => $taxonomyType->hierarchical ? true : false,
            'creationDate'   => (string) $taxonomyType->created_at,
            'lastUpdate'     => (string) $taxonomyType->updated_at,
        ];

        $taxonomyTypeMetaNames = TaxonomyController::getTaxonomyTypeMetaNames(
            $taxonomyType->id
        );

        if ( !empty( $taxonomyTypeMetaNames ) ) {
            $taxonomyTypeTransformed = array_merge(
                $taxonomyTypeTransformed,
                [ 'fields' => $taxonomyTypeMetaNames ]
            );
        }

        $taxonomyTypeTransformed = array_merge( $taxonomyTypeTransformed, [
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('taxonomyTypes.show', $taxonomyType->id)
                ],
                [
                    'rel' => 'taxonomyTypes.taxonomies',
                    'href' => route('taxonomyTypes.taxonomies.index', $taxonomyType->id)
                ],
            ]
        ]);

        return $taxonomyTypeTransformed;

    }

    /**
     * It stablish a relation between the transformed name and the original attribute
     * 
     * @return array
     */
    public static function originalAttribute($index) {
        $attributes = [
            'id'              => 'id',
            'name'            => 'name',
            'description'     => 'description',
            'hierarchical'    => 'hierarchical',
            'creationDate'    => 'created_at',
            'lastUpdate'      => 'updated_at',
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
            'id'           => 'id',
            'name'         => 'name',
            'description'  => 'description',
            'hierarchical' => 'hierarchical',
            'created_at'   => 'creationDate',
            'updated_at'   => 'lastUpdate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
