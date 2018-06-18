<?php

namespace App\Transformers;

use App\Models\Taxonomy;
use App\Models\TaxonomyTypeMeta;
use App\Models\TaxonomyTypeMetaValue;
use League\Fractal\TransformerAbstract;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class TaxonomyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Taxonomy $taxonomy)
    {

        $taxonomyArray = [
            'id'             => $taxonomy['id'],
            'name'           => $taxonomy->name,
            'description'    => $taxonomy->description,
            'image'          => $taxonomy->image,
            'parentId'       => $taxonomy->parent_id,
            'taxonomyTypeId' => $taxonomy->taxonomy_type_id,
            'creationDate'   => (string) $taxonomy->created_at,
            'lastUpdate'     => (string) $taxonomy->updated_at,
        ];

        $taxonomyTypeMetaValues = $this->getTaxonomyTypeMetaValues($taxonomy->id);
        if (!empty($taxonomyTypeMetaValues)) {
            $taxonomyArray['extraData'] = $taxonomyTypeMetaValues;
        }

        $taxonomyArray = array_merge(
            $taxonomyArray, [
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => route('taxonomies.show', $taxonomy['id'])
                    ],
                    [
                        'rel' => 'taxonomy.products',
                        'href' => route('taxonomies.products.index', $taxonomy['id'])
                    ],
                ]
            ]
        );

        return $taxonomyArray;

    }

    /**
     * It gets all the metas available for the taxonomy
     * 
     * @param integer $taxonomyId - The ID of the Taxonomy
     * 
     * @return array
     */
    private function getTaxonomyTypeMetaValues( $taxonomyId ) {

        $taxonomyTypeMetasArray = [];

        // Getting the Taxonomy Type Id
        $taxonomy = Taxonomy::where('id', $taxonomyId)
                        ->first();

        $taxonomyTypeId = $taxonomy->taxonomy_type_id;

        $taxonomyTypeMetas
            = TaxonomyTypeMeta::where('taxonomy_type_id', $taxonomyTypeId)
                ->get();
        
        // Getting all the Taxonomy type metas for the Taxonomy type
        foreach ( $taxonomyTypeMetas as $taxonomyTypeMeta ) {

            // Getting the value for the Taxonomy Meta
            $taxonomyTypeMetaValue = TaxonomyTypeMetaValue::where(
                'taxonomy_type_meta_id', $taxonomyTypeMeta->id
            )->where('taxonomy_id', $taxonomyId)
            ->first();

            if (empty($taxonomyTypeMetaValue)) {
                $taxonomyTypeMetasArray[$taxonomyTypeMeta->name] = null;
            } else {
                $taxonomyTypeMetasArray[$taxonomyTypeMeta->name]
                    = $taxonomyTypeMetaValue->value;
            }
            
        }

        return $taxonomyTypeMetasArray;
    }

    /**
     * It stablish a relation between the transformed name and the original attribute
     * 
     * @return array
     */
    public static function originalAttribute($index)
    {
        $attributes = [
            'id'              => 'id',
            'name'            => 'name',
            'description'     => 'description',
            'image'           => 'image',
            'parentId'        => 'parent_id',
            'taxonomyTypeId'  => 'taxonomy_type_id',
            'creationDate'    => 'created_at',
            'lastUpdate'      => 'updated_at',
        ];

        $taxonomyMetas = TaxonomyController::getTaxonomyTypeMetaNames();

        foreach( $taxonomyMetas as $key => $taxMeta ) {
            $attributes = array_merge(
                $attributes,
                [ $key => $key ]
            );
        }

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * It returns which one is the original attribute
     * 
     * @return array
     */
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'image' => 'image',
            'parent_id' => 'parentId',
            'taxonomy_type_id' => 'taxonomyTypeId',
            'created_at' => 'creationDate',
            'updated_at' => 'lastUpdate',
        ];

        $taxonomyMetas = TaxonomyController::getTaxonomyTypeMetaNames();

        foreach( $taxonomyMetas as $key => $taxMeta ) {
            $attributes = array_merge(
                $attributes,
                [ $key => $key ]
            );
        }

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
