<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Taxonomy\TaxonomyController;

class UpdateUserRequest extends FormRequest
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
            'password' => 'min:6|confirmed|string|max:60',
            'email'    => 'email|unique:users',
            'admin'    => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
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
