<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @transformer \App\Transformers\ProductTransformer
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'max:255',
            'description'       => 'string',
            'image'             => 'max:255|image',
            'legal_text'        => 'string',
            'unit_name'         => 'max:50',
            'quantity_per_unit' => 'max:50',
            'manufacturer_id'   => 'integer|exists:manufacturers,id',
            'discontinued'      => 'boolean',
            'storehouse_stock'  => 'integer|min:0',
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
