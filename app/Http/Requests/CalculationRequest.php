<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
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
            'expression' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?:[0-9\+\-\*\/\^\(\)\s\.]|sqrt)+$/i',
                // Regex breakdown:
                // 0-9: Numbers
                // \+\-\*\/\^: Math operators (escaped)
                // \(\): Parentheses
                // \s: Whitespace/Spaces
                // sqrt: The literal string 'sqrt'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'expression.max' => 'The formula may not be greater than 255 characters.',
            'expression.regex' => 'The formula contains invalid characters. Only numbers, +, -, *, /, ^, (), and sqrt() are allowed.',
        ];
    }
}
