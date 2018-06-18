<?php

namespace App\Http\Requests\Taxonomy;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class UpdateTaxonomyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @transformer \App\Transformers\TaxonomyTransformer
     *
     * @return array
     */
    public function rules()
    {

        $additional_fields = [];

        // Getting the taxonomy id
        $taxonomy_id = $this->route('taxonomy')->id;
        $taxonomy_type_id = $this->route('taxonomy')->taxonomy_type_id;

        if ($taxonomy_id != null) {

            foreach (
                TaxonomyController::getTaxonomyTypeMetaNames($taxonomy_type_id) as $key => $taxonomyTypeMetaName
            ) {
                $additional_fields[$key] = 'nullable|string';
            }
            
        }

        return array_merge(
            [
                'name' => 'unique:taxonomies|string|max:60',
                'description' => 'nullable|string|max:255',
                'image' => 'string|nullable|max:255',
                'parent_id' => 'exists:taxonomies,id|numeric|nullable',
                'taxonomy_type_id' => 'exists:taxonomy_types,id|numeric',
            ],
            $additional_fields
        );

    }

    public function response(array $errors)
    {

        return response()->json([
            'login' => false,
            'errors' => $errors
        ]);

    }
}
