<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class InfoProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = Route::current()->parameter('info_product');
        return [
            'product_key' => [
                'required',
                'string',
                Rule::unique('info_products', 'product_key')->ignore($id),
            ],
            'product_name' => 'required|string',
            'product_description' => 'required|string',
            'product_image' => 'image',
        ];
    }
}
