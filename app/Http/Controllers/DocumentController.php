<?php

namespace App\Http\Controllers;

use App\Document;
use App\Signature;
use Illuminate\Http\Request;
use File;
use DB;
//use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller {

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //echo public_path('document');return;
        //Storage::move('document/G0SZzjPiEM2HxKGNg07zWOZKboV65zxaoj7PVIx5.pdf', 'pdfFiles/G0SZzjPiEM2HxKGNg07zWOZKboV65zxaoj7PVIx5.pdf');
        $this->isAuthorize();
        // Get all User Specific Data
        $userID = $this->request->session()->get('userID');
        $allDocument = Document::where('userID', '=', $userID)->orderBy('id', 'DESC')->paginate(10);
        return view('signature.document', compact('allDocument'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($ID) {
        $this->isAuthorize();
        $document = Document::where('id', '=', $ID)->first();
        $userID = $this->request->session()->get('userID');
        $signatures = Signature::where('userID', '=', $userID)->get();
        return view('signature.show', compact('document', 'signatures'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function delete($ID) {
        $this->isAuthorize();
        $userID = $this->request->session()->get('userID');
        $document = Document::where('userID', '=', $userID)->where('id', '=', $ID)->firstOrFail();
        if (File::exists(public_path($document->docName))) {
            File::delete(public_path($document->docName));
        }
        $document->forceDelete();

        return redirect('documents')->with('status', 'Successfully Document Deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function getSignature(Request $request) {
        $this->isAuthorize();
        $signatureID = $request->input('signature_id');
        $signature = DB::table('signatures')->where('id', '=', $signatureID)->first();
        return response()->json([
                    'name' => $signature->sigFile
        ]);
    }

    public function upload(Request $request) {
        $this->isAuthorize();

        //$path = Storage::putFile('document', $request->file('upload_doc'));
        $fileName = $request->file('upload_doc')->getClientOriginalName();
        $path = $request->file('upload_doc')->move('document', time().'_'.$fileName);
        $userID = $this->request->session()->get('userID');

        $document = new Document;
        $document->title = $fileName;
        $document->userID = $userID;
        $document->docName = $path;

        $document->save();

        return response()->json([
                    'name' => $fileName
        ]);
    }

}
