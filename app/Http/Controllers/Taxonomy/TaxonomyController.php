<?php

namespace App\Http\Controllers\Taxonomy;

use App\Models\Taxonomy;
use Illuminate\Http\Request;
use App\Models\TaxonomyTypeMeta;
use App\Http\Controllers\Controller;
use App\Models\TaxonomyTypeMetaValue;
use App\Http\Controllers\ApiController;
use App\Transformers\TaxonomyTransformer;
use App\Http\Requests\Taxonomy\StoreTaxonomyRequest;
use App\Http\Requests\Taxonomy\UpdateTaxonomyRequest;
use App\Http\Controllers\Taxonomy\TaxonomyTaxonomyTypeMetaController;

class TaxonomyController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TaxonomyTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxonomies = Taxonomy::all();

        return $this->showAll($taxonomies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaxonomyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxonomyRequest $request)
    {
        $taxonomy = Taxonomy::create($request->all());

        $modelParams = Taxonomy::getFillableFields();

        // Saving the extra params
        $extraParams = $request->except( $modelParams );

        $metaHasChanged = $this->saveExtraParams(
            $extraParams,
            $taxonomy->id,
            $taxonomy->taxonomy_type_id
        );

        return $this->showOne($taxonomy, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function show(Taxonomy $taxonomy)
    {
        return $this->showOne($taxonomy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Taxonomy             $taxonomy
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateTaxonomyRequest $request,
        Taxonomy $taxonomy
    ) {

        $modelParams = Taxonomy::getFillableFields();

        // Saving the extra params
        $extraParams = $request->except( $modelParams );

        $metaHasChanged = $this->saveExtraParams(
            $extraParams,
            $taxonomy->id,
            $taxonomy->taxonomy_type_id,
            'UPDATE'
        );

        $taxonomy->fill(
            $request->only(
                $modelParams
            )
        );

        /** TO DO: Validate that the meta values have changed, in order to show the error. */

        if ( $taxonomy->isClean() && $metaHasChanged ) {
            return $this->errorResponse(__('errors.at_least_one_change'), 422);
        }

        $taxonomy->save();

        return $this->showOne($taxonomy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxonomy $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxonomy $taxonomy)
    {
        $taxonomy->delete();

        return $this->showOne($taxonomy);
    }

    /**
     * It gets all the metas available for the taxonomy type
     * 
     * @param integer $taxonomyTypeId - The ID of the Taxonomy type
     * 
     * @return array
     */
    public static function getTaxonomyTypeMetaNames( $taxonomyTypeId = null ) {
        $taxonomyTypeMetaNames = [];

        if( $taxonomyTypeId != null ) {
            $taxonomyTypeMetas = TaxonomyTypeMeta::where('taxonomy_type_id', $taxonomyTypeId )
                                ->orderBy('name','asc')
                                ->get();
        } else {
            $taxonomyTypeMetas = TaxonomyTypeMeta::all();
        }
        
        foreach ( $taxonomyTypeMetas as $taxonomyTypeMeta ) {
            $taxonomyTypeMetaNames[ $taxonomyTypeMeta->name] = [
                'is_mandatory' => $taxonomyTypeMeta->is_mandatory ?
                    'mandatory' : 'not mandatory',
                'taxonomy_type_meta_id' => $taxonomyTypeMeta->id,
            ];
        }

        return $taxonomyTypeMetaNames;
    }

    /**
     * It handles the extra params of a PUT or POST request agains taxonomies.
     * Ignores automatically the values that are not part of the taxonomy type.
     * 
     * @param array  $extraParams      All the Parameters not belonging to the
     *                                 Taxonomy model
     * @param int    $taxonomy_id      The ID of the taxonomy the value belongs to
     * @param int    $taxonomy_type_id The ID of the taxonomy type the values belongs
     *                                 to
     * @param string $mode             (optional) Either INSERT or UPDATE. Default
     *                                 INSERT
     * 
     * @return boolean                 Have at least one field changed?
     */
    public function saveExtraParams(
        $extraParams,
        $taxonomy_id,
        $taxonomy_type_id,
        $mode = 'INSERT'
    ) {

        // Checking if at least a meta value has changed
        $metaHasChanged = false;

        // Changing the meta values if there's at least one in the request
        if( !empty( $extraParams ) ) {

            // Looking for the params in the taxonomy type meta table
            $taxonomyMetas = self::getTaxonomyTypeMetaNames(
                $taxonomy_type_id
            );

            foreach( $extraParams as $key => $extraParam ) {

                // If there's coincidence in the available metas for the taxonomy
                if( isset( $taxonomyMetas[$key] ) ) {

                    // Insert mode, we only create
                    if( $mode === 'INSERT' ) {

                        TaxonomyTypeMetaValue::create([
                            'taxonomy_id'           => $taxonomy_id,
                            'taxonomy_type_meta_id' => $taxonomyMetas[$key]['taxonomy_type_meta_id'],
                            'value'                 => $extraParam,
                        ]);

                    }
                        
                    // Update mode, we create if it doesn't exist, or update if it does
                    if ($mode === 'UPDATE') {

                        $currentValue = TaxonomyTaxonomyTypeMetaController::findCurrentValue(
                            $taxonomy_id,
                            $taxonomyMetas[$key]['taxonomy_type_meta_id']
                        );
    
                        // If the current value doesn't exists, we create it
                        if ($currentValue == null) {
    
                            if ($extraParam != '') {

                                TaxonomyTypeMetaValue::create(
                                    [
                                        'taxonomy_id'           => $taxonomy_id,
                                        'taxonomy_type_meta_id' => $taxonomyMetas[$key]['taxonomy_type_meta_id'],
                                        'value'                 => $extraParam,
                                    ]
                                );

                            }
    
                        } else {
    
                            //echo "[".$key."]".$extraParam." ";
                            // Should we delete the value? If it's empty we delete it
                            if( $extraParam != '' ) {

                                $currentValue->fill([
                                    'value' => $extraParam,
                                ]);
        
                            } else {
                                
                                $currentValue->delete();

                            }

                            if ($currentValue->isClean()) {
                                $metaHasChanged = false;
                            }
    
                            $currentValue->save();
    
                        }

                    }

                }

            }

        }

        return $metaHasChanged;

    }
}
