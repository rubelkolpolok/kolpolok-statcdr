<?php

namespace App\Http\Controllers;

use App\Apt_time_slot;
use DB;
use App\User;
use App\Apt_event;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTimeslot;
use Illuminate\Support\Facades\Auth;

class AptTimeSlotController extends Controller
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
     * Get Event Name.
     *
     * @param  $eventID int Event ID
     * @return string
     */
    public static function eventName($eventID){
        $event = Apt_event::findOrFail($eventID);
        return $event->evtName;
    }

    /**
     * Get Agent Name.
     *
     * @param  $agentID int Agent ID
     * @return string
     */
    public static function agentName($agentID){
        $user = User::findOrFail($agentID);
        return $user->name;
    }

    /**
     * Get Slot Date.
     *
     * @param  $slotID int Data Time Slot ID
     * @return string
     */
    public static function slotDate($slotID){
        $slot = Apt_time_slot::findOrFail($slotID);
        return date('Y-m-d', strtotime($slot->time_slot));
    }

    /**
     * Get Slot Time.
     *
     * @param  $slotID int Data Time Slot ID
     * @return string
     */
    public static function slotTime($slotID){
        $slot = Apt_time_slot::findOrFail($slotID);
        return date('g:i A', strtotime($slot->time_slot))." - ".date('g:i A', strtotime($slot->time_slot.' + '.$slot->slot_duration.' minute'));
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
        $allTimeslot = Apt_time_slot::where('userID','=',$userID)->orderBy('id','DESC')->paginate(10);
        return view('appointments.timeslot.index', compact('allTimeslot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->isAuthorize();

        // Load the Create View
        $userID = $this->request->session()->get('userID');
        //echo $userID;die();
        $allEvents = Apt_event::where('userID','=',$userID)->pluck('evtName', 'id');
        //DB::enableQueryLog();
        $allEmployee = DB::table('users AS u')
                            ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                            ->select('u.id','u.name')
                            ->where('ur.userType', '=', 4)
                            ->where('ur.parentID', '=', $userID)
                            ->orderBy('ur.user_id', 'ASC')
                            ->pluck('name', 'id');
        //dd(DB::getQueryLog());
        return view('appointments.timeslot.create', compact('allEvents', 'allEmployee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTimeslot  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeslot $request){
        $this->isAuthorize();

        // Insert Data
        $insertData = $request->toArray();
        $userID = $this->request->session()->get('userID');
        $timeSlotNum = $insertData['time_slot_no'];
        if(!isset($timeSlotNum) || ($timeSlotNum == NULL) || ($timeSlotNum == '')){
            $timeSlotNum = 1;
        }
        for($i = 0 ; $i < $timeSlotNum ; $i++){
            $data = array();
            if($i > 0){
                $data['time_slot'] = date('Y-m-d H:i:s', strtotime($insertData['time_slot'].' + '.($insertData['slot_duration']*$i).' minute'));
            }else{
                $data['time_slot'] = $insertData['time_slot'];
            }
            $data['userID'] = $userID;
            $data['evtID'] = $insertData['evtID'];
            $data['agentID'] = $insertData['agentID'];
            $data['slot_duration'] = $insertData['slot_duration'];
            Apt_time_slot::create($data);
        }
        return redirect('appointments/timeslot')->with('status', 'Successfully New Timeslot Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $timeslotID int  Timeslot ID
     * @return \Illuminate\Http\Response
     */
    public function edit($timeslotID){
        $this->isAuthorize();

        // Get Specific Data
        $userID    = $this->request->session()->get('userID');
        $allEvents = Apt_event::where('userID','=',$userID)->pluck('evtName', 'id');
        $allEmployee = DB::table('users AS u')
                            ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                            ->select('u.id','u.name')
                            ->where('ur.userType', '=', 4)
                            ->where('ur.parentID', '=', $userID)
                            ->orderBy('ur.user_id', 'ASC')
                            ->pluck('name', 'id');
        $timeslot  = Apt_time_slot::where('userID','=',$userID)->where('id','=',$timeslotID)->firstOrFail();
        return view('appointments.timeslot.edit', compact('timeslot','allEvents', 'allEmployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreTimeslot $request
     * @param  $timeslotID int Timeslot ID
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTimeslot $request, $timeslotID){
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $timeslot = Apt_time_slot::where('userID','=',$userID)->where('id','=',$timeslotID)->firstOrFail();
        $timeslot->evtID         = $request['evtID'];
        $timeslot->agentID       = $request['agentID'];
        $timeslot->time_slot     = $request['time_slot'];
        $timeslot->slot_duration = $request['slot_duration'];
        $timeslot->save();
        return redirect('appointments/timeslot')->with('status', 'Successfully Time Slot Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $timeslotID int Timeslot ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($timeslotID){
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $timeslot = Apt_time_slot::where('userID','=',$userID)->where('id','=',$timeslotID)->firstOrFail();
        $timeslot->forceDelete();
        return redirect('appointments/timeslot')->with('status', 'Successfully Time Slot Deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(Request $request){
        $this->isAuthorize();

        // Delete the Data
        $userID = $this->request->session()->get('userID');
        $ids = $request->ids;
        DB::table("apt_time_slots")->where('userID','=',$userID)->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Deleted successfully."]);
    }
}
