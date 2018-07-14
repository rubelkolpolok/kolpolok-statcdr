<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeslot extends FormRequest
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
            'evtID'         => 'required',
            'agentID'       => 'required',
            'time_slot'     => 'required|date',
            'slot_duration' => 'required|integer'
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
            'evtID.required'   => 'Event Selection is mandatory.',
            'agentID.required' => 'Agent Selection is mandatory.',

            'time_slot' => [
                'required' => 'Time Slots is mandatory.',
                'date'     => 'Time Slots must be a date.'
            ],

            'slot_duration' => [
                'required' => 'Appointments Duration is mandatory.',
                'integer'  => 'Appointments Duration must be an Integer.'
            ]
        ];
    }
}
