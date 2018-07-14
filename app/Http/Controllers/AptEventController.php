<?php

namespace App\Http\Controllers;

use App\Apt_event;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEvent;
use Illuminate\Support\Facades\Auth;

class AptEventController extends Controller
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
        $allEvents = Apt_event::where('userID','=',$userID)->orderBy('id','DESC')->paginate(10);
        return view('appointments.events.index', compact('allEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->isAuthorize();

        // Load the Create View
        return view('appointments.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEvent  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvent $request){
        $this->isAuthorize();

        // Insert Data
        $insertData = $request->toArray();
        $insertData['userID'] = $this->request->session()->get('userID');
        Apt_event::create($insertData);
        return redirect('appointments/events')->with('status', 'Successfully New Event Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $eventID int  Event ID
     * @return \Illuminate\Http\Response
     */
    public function edit($eventID){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $event = Apt_event::where('userID','=',$userID)->where('id','=',$eventID)->firstOrFail();
        return view('appointments.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreEvent  $request
     * @param  $eventID int  Event ID
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEvent $request, $eventID){
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $event = Apt_event::where('userID','=',$userID)->where('id','=',$eventID)->firstOrFail();
        $event->evtName    = $request['evtName'];
        $event->evtAddr    = $request['evtAddr'];
        $event->evtStart   = $request['evtStart'];
        $event->evtEnd     = $request['evtEnd'];
        $event->evtShowWeb = $request['evtShowWeb'];
        $event->save();
        return redirect('appointments/events')->with('status', 'Successfully Event Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $eventID int  Event ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($eventID){
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $event = Apt_event::where('userID','=',$userID)->where('id','=',$eventID)->firstOrFail();
        $event->forceDelete();
        return redirect('appointments/events')->with('status', 'Successfully Event Deleted!');
    }
}
