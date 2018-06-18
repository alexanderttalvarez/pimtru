<?php

namespace App\Http\Requests\Taxonomy;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaxonomyTypeRequest extends FormRequest
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
        return [
            'name' => 'required|unique:taxonomy_types|string|max:60',
            'description' => 'nullable|string|max:255',
            'hierarchical' => 'required|boolean',
        ];
    }

    /**
     * Shows a response if an error produces
     * @return array
     */
    public function response(array $errors)
    {

        return new JsonResponse([
            'created' => false,
            'errors' => $errors
        ]);

    }
}
