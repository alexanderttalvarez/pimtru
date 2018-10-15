<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class StoreUserRequest extends FormRequest
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
            'name'     => 'required|string|max:60',
            'email'    => 'min:6|required|string|max:60|unique:users',
            'password' => 'required|string|max:60',
        ];

    }

    public function response(array $errors)
    {

        return new JsonResponse([
            'created' => false,
            'errors' => $errors
        ]);

    }
}
