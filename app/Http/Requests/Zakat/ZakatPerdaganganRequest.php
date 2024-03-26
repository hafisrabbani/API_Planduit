<?php

namespace App\Http\Requests\Zakat;

use Illuminate\Foundation\Http\FormRequest;

class ZakatPerdaganganRequest extends FormRequest
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
            'rotated_capital' => ['required', 'numeric'],
            'current_recievable' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
            'current_payable' => ['required', 'numeric'],
            'loss' => ['required', 'numeric'],
        ];
    }
}
