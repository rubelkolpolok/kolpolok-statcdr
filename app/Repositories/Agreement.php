<?php
/**
 * Created by PhpStorm.
 * User: rubel.kolpolok
 * Date: 7/6/2018
 * Time: 10:16 AM
 */

namespace App\Repositories;


use App\Agmt_list;
use App\Agmt_list_value;
use App\Reference;
use Auth;
use Illuminate\Http\Request;

class Agreement
{
    public function store(Request $request)
    {
        $data = $request->only('agmtTypeID','signatureID');
        $data['userID'] = Auth::id();
        $data['status'] = ($request->agmtStatus == 1) ? 0 : 1;
        $data['sendMail'] = 0;
        $agreement = Agmt_list::create($data);
        $this->agreementValueStore($request, $agreement);
        $this->referenceStore($request, $agreement);
        return $agreement;
    }

    public function agreementValueStore(Request $request, Agmt_list $agmt_list)
    {
        $columnSize = count($request->columnID);
        if($columnSize > 0){
            for($i = 0 ; $i < $columnSize ; $i++){
                $agmtListValueData = [
                    'userID'           => Auth::id(),
                    'agmtListID'       => $agmt_list->id,
                    'agmtTypeColumnID' => $request['columnID'][$i],
                    'columnValue'      => $request['columnValue'][$i]
                ];
                Agmt_list_value::create($agmtListValueData);
            }
        }
    }

    public function referenceStore(Request $request, Agmt_list $agmt_list)
    {
        $columnSize = count($request->ref_name);
        if($columnSize > 0){
            for($i = 0 ; $i < $columnSize ; $i++){
                $data = [
                    'name' => $request['ref_name'][$i],
                    'agreement_id' => $agmt_list->id,
                    'company' => $request['ref_company'][$i],
                    'designation' => $request['ref_designation'][$i],
                    'phone' => $request['ref_phone'][$i],
                    'email' => $request['ref_email'][$i]
                ];
                $agmt_list->references()->create($data);
            }
        }
    }
}