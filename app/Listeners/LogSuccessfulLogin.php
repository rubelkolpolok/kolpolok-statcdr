<?php

namespace App\Listeners;

use DB;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
{
    private $request;
    /**
     * Create the event listener.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event){
        $userDetails      = $event->user;
        $usersRoleDetails = DB::table('role_user')
                                ->select('*')
                                ->where('user_id', '=', $userDetails->id)
                                ->first();

        $this->request->session()->put('userID', $userDetails->id);
        $this->request->session()->put('userName', $userDetails->name);
        $this->request->session()->put('userEmail', $userDetails->email);

        $this->request->session()->put('userRole', $usersRoleDetails->role_id);
        $this->request->session()->put('userPlan', $usersRoleDetails->userPlan);
        $this->request->session()->put('userParent', $usersRoleDetails->parentID);
        $this->request->session()->put('userType', $usersRoleDetails->userType);
    }
}
