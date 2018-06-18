<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Product;

/**
 * It transform the product's array, adding new properties and
 * changing the name of some keys.
 */
class ProductTransformer extends TransformerAbstract
{
    
    /**
     * A Fractal transformer.
     * 
     * @param Product $product - Product instance
     *
     * @return array
     */
    public function transform(Product $product)
    {

        $transformedProduct = [];

        $manufacturer = null;
        if( !empty( $product->manufacturer ) ) {
            $transformer = $product->manufacturer->transformer;
            $transformation = fractal($product->manufacturer, new $transformer);
            $manufacturer = $transformation->toArray()['data'];
            unset($manufacturer['links']);
        }

        $transformedProduct = [
            'name'            => (string)$product->name,
            'description'     => (string)$product->description,
            'price'           => (float)$product->price,
            'image'           => (string)$product->image,
            'legalText'       => (string)$product->legal_text,
            'quantityPerUnit' => (string)$product->quantity_per_unit,
            'unitName'        => (string)$product->unit_name,
            'storehouseStock' => (int)$product->storehouse_stock,
            'discontinued'    => (boolean)$product->discontinued,
            'manufacturer'    => $manufacturer,
            'creationDate'    => (string)$product->created_at,
            'lastUpdate'      => (string)$product->updated_at,
            'removalDate'     => isset($product->deleted_at) ? (string) $product->deleted_at : null,
            'links' => [
                [
                    'rel'     => 'self',
                    'href'    => route('products.show', $product->id)
                ],
                [
                    'rel' => 'product.taxonomies',
                    'href' => route('products.taxonomies.index', $product->id)
                ],
            ]
        ];

        // Adding conditional link to manufacturer
        if( $product->manufacturer_id != null && $product->manufacturer_id != '' ) {

            $transformedProduct['links'][] = [
                'rel'  => 'product.manufacturer',
                'href' => route('manufacturers.show', $product->manufacturer_id)
            ];

        }

        return $transformedProduct;
    }

    /**
     * It stablish a relation between the transformed name and the original attribute
     * 
     * @return array
     */
    public static function originalAttribute($index) {
        $attributes = [
            'name'            => 'name',
            'description'     => 'description',
            'price'           => 'price',
            'image'           => 'image',
            'legalText'       => 'legal_text',
            'quantityPerUnit' => 'quantity_per_unit',
            'unitName'        => 'unit_name',
            'storehouseStock' => 'storehouse_stock',
            'manufacturerId'  => 'manufacturer_id',
            'discontinued'    => 'discontinued',
            'creationDate'    => 'created_at',
            'lastUpdate'      => 'updated_at',
            'removalDate'     => 'deleted_at',
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
            'name'              => 'name',
            'description'       => 'description',
            'price'             => 'price',
            'image'             => 'image',
            'legal_text'        => 'legalText',
            'quantity_per_unit' => 'quantityPerUnit',
            'unit_name'         => 'unitName',
            'storehouse_stock'  => 'storehouseStock',
            'manufacturer_id'   => 'manufacturerId',
            'discontinued'      => 'discontinued',
            'created_at'        => 'creationDate',
            'updated_at'        => 'lastUpdate',
            'deleted_at'        => 'removalDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
