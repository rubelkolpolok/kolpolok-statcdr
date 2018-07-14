<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket_reply;

class ReplyController extends Controller {

    private $request;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->middleware("role:admin");
        $this->request = $request;
    }

    public function isAuthorize() {
        $userPlan = $this->request->session()->get('userPlan');
        return ($userPlan >= 1) ? true : abort(404);
    }

    public function save(Request $request) {
        $this->isAuthorize();
        $this->validate($request, [
            'description' => 'required'
        ]);
        $reply = new Ticket_reply();
        //On left field name in DB and on right field name in Form/view
        $reply->ticketID = $request->input('ticketID');
        $reply->description = $request->input('description');
        $reply->replyEmail = $this->request->session()->get('userEmail');
        $reply->repliedBy = 1;
        $reply->save();
        return redirect('tickets')->with('status', 'Successfully Replied');
    }

}
