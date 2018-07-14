<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDispute extends FormRequest
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
            'disputeType' => 'required',
            'disputeName' => 'nullable|max:191',
            'prtName'     => 'required',
            'fromDate'    => 'required|date',
            'toDate'      => 'required|date',

            'fileNoA'     => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'fileNoB'     => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',

            'col1Aaa'     => 'required',
            'col11Aaa'    => 'required',
            'col2Aaa'     => 'required',
            'col3Aaa'     => 'required',
            'col4Aaa'     => 'required',
            'col44Aaa'    => 'required',

            'col1Bee'     => 'required',
            'col11Bee'    => 'required',
            'col2Bee'     => 'required',
            'col3Bee'     => 'required',
            'col4Bee'     => 'required',
            'col44Bee'    => 'required'
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
            'disputeType.required' => 'Dispute Type is mandatory.',
            'disputeName.required' => 'Dispute Name is mandatory.',
            'prtName.required'     => 'Partner Name is mandatory.',
            'fromDate.required'    => 'Dispute From Date is mandatory.',
            'toDate.required'      => 'Dispute To Date is mandatory.',

            'fileNoA.required'  => 'File upload is Mandatory.',
            'fileNoA.mimetypes' => 'Only .xlsx, .xls formats are allowed.',
            'fileNoB.required'  => 'File upload is Mandatory.',
            'fileNoB.mimetypes' => 'Only .xlsx, .xls formats are allowed.',

            'col1Aaa.required'  => 'Datetime Selection is Mandatory.',
            'col11Aaa.required' => 'Datetime Timezone Selection is Mandatory.',
            'col2Aaa.required'  => 'ANI(Caller_number) Selection is Mandatory.',
            'col3Aaa.required'  => 'Called Number Selection is Mandatory.',
            'col4Aaa.required'  => 'Duration Selection is Mandatory.',
            'col44Aaa.required' => 'Duration Type Selection is Mandatory.',

            'col1Bee.required'  => 'Datetime Selection is Mandatory.',
            'col11Bee.required' => 'Datetime Timezone Selection is Mandatory.',
            'col2Bee.required'  => 'ANI(Caller_number) Selection is Mandatory.',
            'col3Bee.required'  => 'Called Number Selection is Mandatory.',
            'col4Bee.required'  => 'Duration Selection is Mandatory.',
            'col44Bee.required' => 'Duration Type Selection is Mandatory.'
        ];
    }
}
