<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Manufacturer;

class ManufacturerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Manufacturer $manufacturer)
    {
        return [
            'name'         => (string)$manufacturer->name,
            'description'  => (string)$manufacturer->description,
            'address'      => (string)$manufacturer->address,
            'country'      => (string)$manufacturer->country,
            'region'       => (string)$manufacturer->region,
            'phoneNumber'  => (string)$manufacturer->telephone,
            'creationDate' => (string)$manufacturer->created_at,
            'lastUpdate'   => (string)$manufacturer->updated_at,
            'removalDate'  => isset($manufacturer->deleted_at) ? (string) $manufacturer->manufacturer : null,
            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('manufacturers.show', $manufacturer->id)
                ]
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
            'name'           => 'name',
            'description'    => 'description',
            'address'        => 'address',
            'country'        => 'country',
            'region'         => 'region',
            'phoneNumber'    => 'telephone',
            'creationDate'   => 'created_at',
            'lastUpdate'     => 'updated_at',
            'removalDate'    => 'deleted_at',
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
            'name'        => 'name',
            'description' => 'description',
            'address'     => 'address',
            'country'     => 'country',
            'region'      => 'region',
            'telephone'   => 'phoneNumber',
            'created_at'  => 'creationDate',
            'updated_at'  => 'lastUpdate',
            'deleted_at'  => 'removalDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
