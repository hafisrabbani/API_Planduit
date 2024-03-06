<?php

namespace App\Http\Requests\Zakat;

use Illuminate\Foundation\Http\FormRequest;

class ZakatPenghasilanRequest extends FormRequest
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
            'income' => 'required|numeric|min:1',
            'another_income' => 'required|numeric|min:0',
            'expenditure' => 'required|numeric|min:0',
            'time_type' => 'required|in:YEARLY,MONTHLY',
        ];
    }
}
