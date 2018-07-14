<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
        switch($this->method()) {
            case 'POST':
            {
                return [
                    'userType' => 'required',
                    'userPlan' => 'required',
                    'name'     => 'required|min:3|max:50',
                    'email'    => 'required|email|unique:users',
                    'password' => 'required|confirmed|min:6'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'userType' => 'required',
                    'userPlan' => 'required',
                    'name'     => 'required|min:3|max:50',
                    'email'    => Rule::unique('users')->ignore($this->id)
                ];
            }
            default: break;
        }
    }
}
