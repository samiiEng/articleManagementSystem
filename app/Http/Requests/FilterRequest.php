<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'outputTable' => 'required|string',
            'outputFields' => 'required|string',
            'hasDistinct' => 'required|boolean',
            '*.field' => 'required|string',
            '*.operator' => 'required', Rule::in(['>', '=', '<', 'LIKE']),
            '*.value' => 'required|string|integer',
            '*.next' => 'required', Rule::in(['AND', 'OR', "NULL"])
        ];
    }
}
