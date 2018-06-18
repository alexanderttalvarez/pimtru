<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

/**
 * Manage all the products data.
 * 
 * @resource Product
 */
class ProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
    }

    /**
     * Show all products
     *
     * @return \Illuminate\Http\Response
     * 
     * @response {
     *   data: [],
     * }
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    /**
     * Create new product
     *
     * @param \App\Http\Requests\Product\StoreProductRequest $request All the parameters for creating the product
     * 
     * @return \Illuminate\Http\Response JSON
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        return $this->showOne($product, 201);
    }

    /**
     * Show single product
     *
     * @param \App\Models\Product $product
     * 
     * @return \Illuminate\Http\Response JSON
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Update product
     *
     * @param \App\Http\Requests\Product\UpdateProductRequest $request All the parameters for creating the product
     * @param \App\Models\Product $product
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

        $product->fill(
            $request->only(
                [
                    'name',
                    'description',
                    'legal_text',
                    'quantity_per_unit',
                    'unit_name',
                    'image',
                    'storehouse_stock',
                    'manufacturer_id',
                    'discontinued'
                ]
            )
        );

        if ($product->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove product
     *
     * @param \App\Models\Product $product - Product instance
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->showOne($product);
    }
}
