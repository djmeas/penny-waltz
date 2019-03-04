<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTransactionRequest extends FormRequest
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
            'category_id' => 'required',
            'type_id' => 'required',
            'amount' => 'required|numeric|gt:0',
            'short_description' => 'required',
            'date' => 'required|date_format:m/d/Y'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => 'Please select a category.',
            'type_id.required' => 'Please select a type.',
            'amount.numeric' => 'The amount needs to be a number.',
            'amount.gt' => 'The amount needs to be greater than 0.',
            'date.date_format'  => 'The date must be in mm/dd/yyyy.',
        ];
    }

}
