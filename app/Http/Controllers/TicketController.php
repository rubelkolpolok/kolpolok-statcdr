<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Ticket_reply;
use App\Http\Requests\StoreTicket;
use Webklex\IMAP\Client;
//use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TicketController extends Controller {

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

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function isAuthorize() {
        $userPlan = $this->request->session()->get('userPlan');
        return ($userPlan >= 1) ? true : abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->isAuthorize();

        $allTickets = Ticket::latest()->paginate(10);
        return view('tickets.index', compact('allTickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->isAuthorize();

        // Load the Create View
        return view('tickets.create');
    }

    public function show($ticketID) {
        $this->isAuthorize();
        $ticket = Ticket::where('id', '=', $ticketID)->first();
        $replies = Ticket_reply::where('ticketID', $ticketID)
                ->orderBy('created_at', 'asc')
                ->get();

        if (empty($ticket)) {
            return redirect('tickets')->with('status', 'No Ticket Found');
        }
        return view('tickets.show', compact('ticket', 'replies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicket  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicket $request) {
        $this->isAuthorize();

        // Insert Data
        $insertData = $request->toArray();
        Ticket::create($insertData);
        return redirect('tickets')->with('status', 'Successfully Ticket Created!');
    }

    public function mtest() {

        $oClient = new Client([
            'host' => 'kolpolok.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'rejoan@kolpolok.com',
            'password' => 'Rejoan!@#',
        ]);

//Connect to the IMAP Server
        $oClient->connect();

//Get all Mailboxes
        /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
        $oFolder = $oClient->getFolder('INBOX');
        $aMessage = $oFolder->searchMessages([['UNSEEN']]);
//        var_dump(count($aMessage));
//        return;
        /** @var \Webklex\IMAP\Message $oMessage */
        foreach ($aMessage as $oMessage) {
            //echo '>>>'.$oMessage->subject . '<br/>';
            echo '<pre>';
            var_dump($oMessage->attachments['ii_jibhml2x0']->oMessage);
            //print_r($oMessage->from[0]->mail);
            //echo 'Attachments: ' . $oMessage->getAttachments() . '<br />';
            //echo $oMessage->getHTMLBody(true);
            //Move the current Message to 'INBOX.read'
//                if ($oMessage->moveToFolder('INBOX.read') == true) {
//                    echo 'Message has ben moved';
//                } else {
//                    echo 'Message could not be moved';
//                }
        }
    }

    public function create_ticket() {
        $this->isAuthorize();

        $oClient = new Client([
            'host' => 'kolpolok.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'rejoan@kolpolok.com',
            'password' => 'Rejoan!@#',
        ]);

//Connect to the IMAP Server
        $oClient->connect();

        $oFolder = $oClient->getFolder('INBOX');
        $aMessage = $oFolder->searchMessages([['SINCE', Carbon::now()->subDays(1)]]);
        if (count($aMessage) < 1) {
            return redirect('tickets')->with('status', 'No new mail');
        }

        foreach ($aMessage as $oMessage) {
            $subject = trim(str_replace(array('Re:'), '', $oMessage->subject));
            $replySubject = trim($oMessage->subject);
            $message = Ticket::where(['subject' => $subject, 'customerEmail' => $oMessage->from[0]->mail])->first();
            if (empty($message)) {// if not found then create new ticket
                $ticket = new Ticket();
                $ticket->supportEmail = $oMessage->to[0]->mail;
                $ticket->customerEmail = $oMessage->from[0]->mail;
                $ticket->subject = $oMessage->subject;
                $ticket->description = $oMessage->bodies['text']->content;
                $ticket->messageId = $oMessage->uid;
                $ticket->save();
            } else {// save as reply
                if (strpos($replySubject, 'Re:') !== 0) {
                    continue;
                }
                $reply = new Ticket_reply();
                $reply->ticketID = $message['id'];
                $reply->description = $oMessage->bodies['text']->content;
                $reply->replyEmail = $oMessage->from[0]->mail;
                $reply->repliedBy = 2;
                $reply->save();
            }
        }

        return redirect('tickets')->with('status', 'Successfully');
    }

}
