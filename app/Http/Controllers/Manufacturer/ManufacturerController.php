<?php

namespace App\Http\Controllers\Manufacturer;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Transformers\ManufacturerTransformer;
use App\Http\Requests\Manufacturer\StoreManufacturerRequest;

class ManufacturerController extends ApiController
{
    public function __construct() {
        parent::__construct();

        $this->middleware('transform.input:' . ManufacturerTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return $this->showAll( $manufacturers );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\Manufacturer\StoreManufacturerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManufacturerRequest $request)
    {
        $manufacturer = Manufacturer::create($request->all());

        return $this->showOne($manufacturer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacturer $manufacturer)
    {
        return $this->showOne( $manufacturer );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\Manufacturer\UpdateManufacturerRequest  $request
     * @param \App\Models\Manufacturer $manufacturer
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $manufacturer->fill(
            $request->only(
                [
                    'name',
                    'description',
                    'address',
                    'country',
                    'region',
                ]
            )
        );

        if ($manufacturer->isClean()) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $manufacturer->save();

        return $this->showOne($manufacturer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Manufacturer $manufacturer
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return $this->showOne($manufacturer);
    }
}
