<?php

namespace App\Http\Requests\Taxonomy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxonomyTypeRequest extends FormRequest
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
     * @transformer \App\Transformers\TaxonomyTypeTransformer
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'unique:taxonomy_types|string|max:60',
            'description' => 'nullable|string|max:255',
            'hierarchical' => 'boolean',
        ];
    }

    public function response(array $errors)
    {

        return response()->json([
            'login' => false,
            'errors' => $errors
        ]);

    }
}
