<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointment extends FormRequest
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
            'evtID'    => 'required',
            'agentID'  => 'required',
            'slotID'   => 'required',
            'cusName'  => 'required',
            'cusEmail' => 'required|email',
            'cusPhn'   => 'required',
            'cusCom'   => 'required',
            'cusSkype' => 'required'
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
            'evtID.required'   => 'Event ID is mandatory, Load this page again.',
            'agentID.required' => 'Meeting person selection is mandatory.',
            'slotID.required'  => 'Meeting Time selection is mandatory.',
            'cusName.required' => 'Your name is mandatory.',

            'cusEmail' => [
                'required' => 'Your Email is mandatory.',
                'email'    => 'Email is not OK.'
            ],

            'cusPhn.required'   => 'Your Phone is mandatory.',
            'cusCom.required'   => 'Your Company Name is mandatory.',
            'cusSkype.required' => 'Your Skype ID is mandatory.'
        ];
    }
}
