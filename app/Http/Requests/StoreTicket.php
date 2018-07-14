<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicket extends FormRequest
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
            'supportEmail'    => 'required',
            'customerEmail'    => 'required',
            'subject'   => 'required',
            'description'     => 'required'
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
            'supportEmail.required'    => 'Support Email is mandatory.',

            'customerEmail.required'    => 'Email Customer is mandatory.',

            'subject.required'   => 'Subject is mandatory.',

            'description.required'     => 'Description is mandatory.'
        ];
    }
}
