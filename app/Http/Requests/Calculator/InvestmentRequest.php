<?php

namespace App\Http\Requests\Calculator;

use Illuminate\Foundation\Http\FormRequest;

class InvestmentRequest extends FormRequest
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
            'target_money' => 'required|numeric|min:1',
            'target_time' => 'required|numeric|min:1',
            'initial_money' => 'required|numeric|min:1',
            'money_investment' => 'required|numeric|min:1',
            'time_type' => 'required|in:YEARLY,MONTHLY',
            'interest' => 'required|numeric|min:1'
        ];
    }
}
