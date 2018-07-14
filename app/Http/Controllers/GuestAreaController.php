<?php

namespace App\Http\Controllers;

use DB;
use App\Apt_event;
use App\Apt_time_slot;
use App\Apt_list;
use App\Agmt_type;
use App\Agmt_type_detail;
use App\Agmt_list;
use App\Agmt_list_value;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAppointment;

class GuestAreaController extends Controller{

    /**
     * Appointment List view for Website Viewer.
     *
     * @return \Illuminate\Http\Response
     */
    public function apt_list(){
        $currentDateTime = date('Y-m-d H:i:s');
        $eventDetails = Apt_event::availableEvent($currentDateTime, 2);
        return view('guest.apt_list', compact('eventDetails'));
    }

    /**
     * Appointment Create view for Website Viewer.
     *
     * @param  $eventID int  Event ID
     * @return \Illuminate\Http\Response
     */
    public function apt_create($eventID){
        $eventDetails = DB::table("apt_events")
                            ->select('id', 'evtName', 'evtAddr')
                            ->where('userID', '=', 2)
                            ->where('id', '=', $eventID)
                            ->first();
        $dateList  = [];
        $agentList = DB::table('users AS u')
                        ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                        ->select('u.id','u.name')
                        ->where('ur.userType', '=', 4)
                        ->where('ur.parentID', '=', 2)
                        ->orderBy('ur.user_id', 'ASC')
                        ->pluck('name', 'id');
        return view('guest.apt_create', compact('eventDetails', 'dateList', 'agentList'));
    }

    /**
     * Return Date Time Slot Date.
     *
     * @param  $eventID int  Event ID
     * @param  $agentID int  Agent ID
     * @return \Illuminate\Http\Response
     */
    public function apt_get_date($eventID, $agentID){
        $slotDetails = Apt_time_slot::availableAgentSlotDate($eventID, $agentID);
        $slotDetails = $slotDetails->toArray();
        if(!empty($slotDetails)){
            $i = 1;
            $data[0]['date_slot'] =  "Select meeting date";
            foreach ($slotDetails as $k => $v) {
                $data[$i]['date_slot'] =  date("Y-m-d", strtotime($v->time_slot));
                $i++;
            }
            $data = array_unique($data, SORT_REGULAR);
        }else{
            $data[0] = [
                'date_slot' => 'Not available.'
            ];
        }
        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $eventID int  Event ID
     * @param  $agentID int  Agent ID
     * @param  $dateM string  Meeting Date
     * @return \Illuminate\Http\Response
     */
    public function apt_get_slot($eventID, $agentID, $dateM){
        $slotDetails = Apt_time_slot::availableAgentSlotTime($eventID, $agentID, $dateM);
        $slotDetails = $slotDetails->toArray();
        if(!empty($slotDetails)){
            $i = 0;
            foreach ($slotDetails as $k => $v) {
                $data[$i]['id'] = $v->id;
                $data[$i]['time_slot'] =  date("g:i A", strtotime($v->time_slot))." - ".date("g:i A", strtotime($v->time_slot.' + '.$v->slot_duration.' minute'));
                $i++;
            }

        }else{
            $data[0] = [
                'id' => NULL,
                'time_slot' => 'Not available.'
            ];
        }
        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointment  $request
     * @return \Illuminate\Http\Response
     */
    public function apt_store(StoreAppointment $request){
        $insertData = $request->toArray();
        $insertData['userID'] = 2;
        Apt_list::create($insertData);
        return redirect('appointments')->with('status', 'Successfully appointment is scheduled!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agmt_list(){
        // get all Agreement Types
        $allAgmtTypes = Agmt_type::where('userID','=',2)->orderBy('showOrder','ASC')->get();
        return view('guest.agmt_list', compact('allAgmtTypes'));
    }

    /**
     * Appointment Create view for Website Viewer.
     *
     * @param  $agmtTypeID int Agreement Type ID
     * @return \Illuminate\Http\Response
     */
    public function agmt_create($agmtTypeID){
        $agmt_type = Agmt_type::where('userID','=',2)->where('id', $agmtTypeID)->get(['typeName','adminApprove'])->toArray();
        $agmt_type_details = Agmt_type_detail::where('userID','=',2)->where('agmtTypeID', "=", $agmtTypeID)->get()->toArray();
        return view('guest.agmt_create', compact('agmt_type', 'agmtTypeID', 'agmt_type_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agmt_store(Request $request){

        $agmtListData = [
            'userID'     => 2,
            'agmtTypeID' => $request['agmtTypeID'],
            'status'     => ($request['agmtStatus'] == 1) ? 0 : 1,
            'sendMail'   => 0
        ];
        $agmtListID = Agmt_list::create($agmtListData)->id;

        $columnSize = sizeof($request['columnID']);
        if($columnSize > 0){
            for($i = 0 ; $i < $columnSize ; $i++){
                $agmtListValueData = [
                    'userID'           => 2,
                    'agmtListID'       => $agmtListID,
                    'agmtTypeColumnID' => $request['columnID'][$i],
                    'columnValue'      => $request['columnValue'][$i]
                ];
                Agmt_list_value::create($agmtListValueData);
            }
        }
        return redirect('agreements/all')->with('status', 'Successfully Agreement Submitted!');
    }
}
