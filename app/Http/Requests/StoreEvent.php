<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            'evtName'    => 'required|max:191',
            'evtAddr'    => 'required',
            'evtStart'   => 'required|date',
            'evtEnd'     => 'required|date',
            'evtShowWeb' => 'required|date'
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
            'evtName.required'    => 'Event Name is mandatory.',
            'evtName.max'         => 'Event Name must be within 191 Character.',

            'evtAddr.required'    => 'Event Address is mandatory.',

            'evtStart.required'   => 'Starting Date is mandatory.',
            'evtStart.date'       => 'Starting Date must be a date.',

            'evtEnd.required'     => 'Ending Date is mandatory.',
            'evtEnd.date'         => 'Ending Date must be a date.',

            'evtShowWeb.required' => 'Showing in Website Date is mandatory.',
            'evtShowWeb.date'     => 'Showing in Website Date must be a date.'
        ];
    }
}
