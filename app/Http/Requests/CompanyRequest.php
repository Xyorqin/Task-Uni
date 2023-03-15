<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CompanyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              => 'required|min:2',
            'address'           => 'nullable|min:3',
            'password'          => 'nullable',
            'phone_number'      => 'required|min:13|max:13',
            'ceo_first_name'    => 'required|min:3',    
            'ceo_last_name'     => 'nullable',
            'ceo_middle_name'   => 'nullable',
            'email'             => 'nullable',
            'website'           => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required'             => 'Name is required',
            'ceo_first_name.required'   => 'First name of CEO is required'
        ];
    }
}
