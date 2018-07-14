<?php

namespace App\Http\Controllers;

use App\Signature;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Http\Requests\StoreSignature;

class SignatureController extends Controller {

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

        // Get all User Specific Data
        $userID = $this->request->session()->get('userID');
        $allSignature = Signature::where('userID', '=', $userID)->orderBy('id', 'DESC')->paginate(10);
        return view('signature.index', compact('allSignature'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->isAuthorize();

        // Load the Create View
        return view('signature.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSignature  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSignature $request) {
        $this->isAuthorize();

        // Insert Data
        $data = [
            'userID' => $this->request->session()->get('userID'),
            'sigTitle' => $request['sigTitle']
        ];
        $sigID = Signature::create($data)->id;

        $sigFile = $request->file('sigFile');
        $sigExt = $sigFile->getClientOriginalExtension();
        $sigFileName = time() . '_' . $sigID . '.' . $sigExt;
        $sigFile->storeAs('signatures', $sigFileName, 'public');

        $dataUpdate = [
            'sigFile' => $sigFileName
        ];
        Signature::where('ID', $sigID)->update($dataUpdate);

        return redirect('signature')->with('status', 'Successfully New Signature Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $sigID int Signature ID
     * @return \Illuminate\Http\Response
     */
    public function edit($sigID) {
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $signature = Signature::where('userID', '=', $userID)->where('id', '=', $sigID)->firstOrFail();
        return view('signature.edit', compact('signature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreSignature  $request
     * @param  $sigID int Signature ID
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSignature $request, $sigID) {
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $signature = Signature::where('userID', '=', $userID)->where('id', '=', $sigID)->firstOrFail();

        $sigFile = $request->file('sigFile');
        $sigExt = $sigFile->getClientOriginalExtension();
        $sigFileName = $sigID . '.' . $sigExt;
        $sigFile->storeAs('signatures', $sigFileName, 'public');

        $signature->sigTitle = $request['sigTitle'];
        $signature->sigFile = $sigFileName;
        $signature->save();
        return redirect('signature')->with('status', 'Successfully Signature Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $sigID int Signature ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($sigID) {
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $signature = Signature::where('userID', '=', $userID)->where('id', '=', $sigID)->firstOrFail();
        if (File::exists(storage_path('app/public/signatures/' . $signature->sigFile))) {
            File::delete(storage_path('app/public/signatures/' . $signature->sigFile));
        }
        $signature->forceDelete();

        return redirect('signature')->with('status', 'Successfully Signature Deleted!');
    }

}
