<?php

namespace App\Http\Controllers;

use DB;
use App\Apt_event;
use App\Apt_time_slot;
use App\Apt_list;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAppointment;
use Illuminate\Support\Facades\Auth;

class AptListController extends Controller
{
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware("role:admin");
        $this->request = $request;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function isAuthorize(){
        $userPlan = $this->request->session()->get('userPlan');
        return ($userPlan >= 1)? true : abort(404) ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $this->isAuthorize();

        // Get all User Specific Data
        $userID = $this->request->session()->get('userID');
        $allAppointment = Apt_list::where('userID','=',$userID)->orderBy('id','DESC')->paginate(10);
        return view('appointments.index', compact('allAppointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $aptID int Appointment ID
     * @return \Illuminate\Http\Response
     */
    public function edit($aptID){
        $this->isAuthorize();

        // Get Specific Data
        $userID    = $this->request->session()->get('userID');
        $appointment = Apt_list::where('userID','=',$userID)->where('id','=',$aptID)->firstOrFail();
        $agentList = DB::table('users AS u')
                        ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                        ->select('u.id','u.name')
                        ->where('ur.userType', '=', 4)
                        ->where('ur.parentID', '=', $userID)
                        ->orderBy('ur.user_id', 'ASC')
                        ->pluck('name', 'id');

        $slotDate = Apt_time_slot::select('time_slot')->where('userID','=',$userID)->where('id','=',$appointment->slotID)->get()->toArray();

        $slotDetails = Apt_time_slot::select('id','time_slot','slot_duration')->where('userID','=',$userID)->where('agentID','=',$appointment->agentID)->whereDate('time_slot', '=', date('Y-m-d', strtotime($slotDate[0]['time_slot'])))->get()->toArray();
        if(!empty($slotDetails)){
            foreach ($slotDetails as $k => $v) {
                $timeList[$v['id']] = date("g:i A", strtotime($v['time_slot']))." - ".date("g:i A", strtotime($v['time_slot'].' + '.$v['slot_duration'].' minute'));
                $dateList[date("Y-m-d", strtotime($v['time_slot']))] = date("Y-m-d", strtotime($v['time_slot']));
            }
        }
        $dateList = array_unique($dateList, SORT_REGULAR);
        return view('appointments.edit', compact('appointment', 'dateList', 'timeList', 'agentList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointment $request
     * @param  $aptID int Appointment ID
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAppointment $request, $aptID){
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $apt = Apt_list::where('userID','=',$userID)->where('id','=',$aptID)->firstOrFail();
        $apt->evtID    = $request['evtID'];
        $apt->agentID  = $request['agentID'];
        $apt->slotID   = $request['slotID'];
        $apt->cusName  = $request['cusName'];
        $apt->cusEmail = $request['cusEmail'];
        $apt->cusPhn   = $request['cusPhn'];
        $apt->cusCom   = $request['cusCom'];
        $apt->cusSkype = $request['cusSkype'];
        $apt->save();
        return redirect('appointments/list')->with('status', 'Successfully Appointment Schedule Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $aptID int Appointment ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($aptID){
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $appointment = Apt_list::where('userID','=',$userID)->where('id','=',$aptID)->firstOrFail();
        $appointment->forceDelete();
        return redirect('appointments/list')->with('status', 'Successfully Appointment Schedule Deleted!');
    }
}
