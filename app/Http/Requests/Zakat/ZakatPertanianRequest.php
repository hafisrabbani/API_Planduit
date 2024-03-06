<?php

namespace App\Http\Requests\Zakat;

use Illuminate\Foundation\Http\FormRequest;

class ZakatPertanianRequest extends FormRequest
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
        return [
            'total_harvest' => 'required|numeric|min:1',
            'is_watered' => 'required|boolean',
            'grain_price' => 'numeric',
        ];
    }
}
