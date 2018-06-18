<?php

namespace App\Http\Requests\Manufacturer;

use Illuminate\Foundation\Http\FormRequest;

class StoreManufacturerRequest extends FormRequest
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
     * @transformer \App\Transformers\ManufacturerTransformer
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'name'         => 'required|max:255',
            'description'  => 'string',
            'address'      => 'max:255|image',
            'country'      => 'max:50|string',
            'region'       => 'max:50|string',
            'phone_number' => 'max:50|string',
        ];
    }

    /**
     * The JSON response
     */
    public function response(array $errors)
    {

        return response()->json([
            'login' => false,
            'errors' => $errors
        ]);

    }
}
