<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser {

    /**
     * Transform the input into a success message Json
     * 
     * @return json
     */
    private function successResponse( $data, $code ) {
        return response()->json( $data, $code );
    }

    /**
     * Transform the input into an error message Json
     * 
     * @return json
     */
    protected function errorResponse( $message, $code ) {
        return response()->json([
            'error' => $message,
            'code'  => $code
        ], $code);
    }

    /**
     * Gets a collection and prepare the data to return a json
     * 
     * @return json
     */
    protected function showAll( Collection $collection, $code = 200 ) {

        if( $collection->isEmpty() ) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        //$collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        //$collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    /**
     * Prepare a single item to return a json
     * 
     * @return json
     */
    protected function showOne( Model $instance, $code = 200 ) {

        $transformer = $instance->transformer;

        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    /**
     * It shows a message
     * 
     * @param string $message The message to show
     * @param int $code The status code
     * @return json
     */
    protected function showMessage($message, $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * It filters the elements of a collection
     * 
     * @param Collection $collection The list of elements to sort
     * @param Transformer $transformer The transformer for showing the elements transformed after the filtering
     */
    protected function filterData(Collection $collection, $transformer) {
        foreach( request()->query() as $query => $value ) {
            $attribute = $transformer::originalAttribute( $query );

            if( isset( $attribute, $value ) ) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    /**
     * It sorts the elements of a collection
     * 
     * @param Collection $collection The list of elements to sort
     * @param Transformer $transformer The transformer for showing the elements transformed after the sorting
     */
    protected function sortData(Collection $collection, $transformer) {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy->{$attribute};
        }
        
        return $collection;
    }

    /**
     * It allows to paginate a collection
     * 
     * @param Collection $collection The list of elements to sort
     */
    protected function paginate(Collection $collection) {

        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(), $rules);
        
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        if(request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }

        $results = $collection->slice(($page-1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator( $results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->appends( request()->all() );

        return $paginated;
    }

    /**
     * It's the responsible of transforming the data using the correct transformer
     * 
     * @param array $data
     * @param Transformer $transformer
     * @return array
     */
    protected function transformData($data, $transformer) {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data) {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function() use($data) {
            return $data;
        });
    }

}