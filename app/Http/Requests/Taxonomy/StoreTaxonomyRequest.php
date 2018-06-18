<?php

namespace App\Http\Requests\Taxonomy;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class StoreTaxonomyRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $additional_fields = [];

        if (request()->taxonomy_type_id != null) {

            // Getting the taxonomy type id
            $taxonomy_type_id = request()->taxonomy_type_id;

            foreach (
                TaxonomyController::getTaxonomyTypeMetaNames($taxonomy_type_id) as $key => $taxonomyTypeMetaName
            ) {

                if ($taxonomyTypeMetaName['is_mandatory'] == 'mandatory') {
                    $additional_fields[$key] = 'required|string';
                } else {
                    $additional_fields[$key] = 'string';
                }
                
            }

        }

        return array_merge(
            [
                'name' => 'required|unique:taxonomies|string|max:60',
                'description' => 'nullable|string|max:255',
                'image' => 'string|nullable|max:255',
                'parent_id' => 'exists:taxonomies,id|numeric|nullable',
                'taxonomy_type_id' => 'required|exists:taxonomy_types,id|numeric',
            ],
            $additional_fields
        );
    }

    public function response(array $errors)
    {

        return new JsonResponse([
            'created' => false,
            'errors' => $errors
        ]);

    }
}
