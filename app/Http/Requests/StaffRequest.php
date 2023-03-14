<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StaffRequest extends FormRequest
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
            'first_name'    => 'required|min:3',
            'last_name'     => 'nullable|min:3',
            'middle_name'   => 'nullable|min:3',
            'position'      => 'nullable|min:3',
            'phone_number'  => "required|string|unique:staffs",
            'address'       => 'nullable|min:3',
            'company_id'    => 'required|exists:companies,id',
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
            'phone_number.required' => 'Phone number is required',
            'company_id.required'   => 'Company must be selected',
            'first_name.required'   => 'First name is required',
        ];
    }
}
