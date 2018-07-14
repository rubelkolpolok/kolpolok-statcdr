<?php

namespace App\Http\Controllers;

use App\Mail\TradeEnquiry;
use App\Mail\WelcomeMessage;
use App\Reference;
use App\Repositories\Agreement;
use App\User;
use DB;
use App\Agmt_list;
use App\Agmt_list_value;
use App\Agmt_type;
use App\Agmt_type_detail;
use App\Agmt_list_upload;
use App\Signature;
use Mail;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgmtListController extends Controller
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
    public function isAuthorize()
    {
        $userPlan = $this->request->session()->get('userPlan');
        return ($userPlan >= 1) ? true : abort(404);
    }

    /**
     * Get Agreement Type Name.
     *
     * @param  $agmtTypeID int Agreement Type ID
     * @return string
     */
    public static function agmtTypeName($agmtTypeID)
    {
        $agmtType = Agmt_type::findOrFail($agmtTypeID);
        return $agmtType->typeName;
    }

    /**
     * Get Agreement Type Column Name.
     *
     * @param  $agmtColumnID int Agreement Type Column ID
     * @return string
     */
    public static function agmtColumnName($agmtColumnID)
    {
        $column = Agmt_type_detail::findOrFail($agmtColumnID);
        return $column->columnName;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->isAuthorize();

        // Get all User Specific Data
        $userID = $this->request->session()->get('userID');
        $allAgmtList = Agmt_list::where('userID', '=', $userID)->orderBy('id', 'DESC')->get();
        return view('agreement.index', compact('allAgmtList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $this->isAuthorize();

        // Get all User Specific Data
        $userID = $this->request->session()->get('userID');
        $allAgmtTypes = Agmt_type::where('userID', '=', $userID)->orderBy('showOrder', 'ASC')->paginate(10);
        return view('agreement.list', compact('allAgmtTypes'));
    }

    /**
     * Appointment Create view for Website Viewer.
     *
     * @param  $agmtTypeID int Agreement Type ID
     * @return \Illuminate\Http\Response
     */
    public function create($agmtTypeID)
    {
        $this->isAuthorize();

        // Load the Create View
        $userID = $this->request->session()->get('userID');
        $allSignature = Signature::where('userID', '=', $userID)->pluck('sigTitle', 'id');
        $agmt_type = Agmt_type::where('id', '=', $agmtTypeID)->where('userID', '=', $userID)->get(['typeName', 'adminApprove'])->toArray();
        $agmt_type_details = Agmt_type_detail::where('agmtTypeID', "=", $agmtTypeID)->where('userID', '=', $userID)->get()->toArray();
        return view('agreement.create', compact('agmt_type', 'agmtTypeID', 'agmt_type_details', 'allSignature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->isAuthorize();
        // agreement list and value data store
        $agreement = (new Agreement)->store($request);
        $user_email = User::whereId($agreement->userID)->first()->email;
        Mail::to($user_email)->send(new WelcomeMessage());

        return redirect('agreement/list')->with('status', 'Successfully Agreement Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $agmtListID int  Agreement List ID
     * @return \Illuminate\Http\Response
     */
    public function edit($agmtListID)
    {
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $agmt_list = Agmt_list::where('userID', '=', $userID)->where('id', '=', $agmtListID)->firstOrFail();
        $agmt_list_type = DB::table('agmt_list_values AS lv')
            ->leftJoin('agmt_type_details AS td', 'td.id', '=', 'lv.agmtTypeColumnID')
            ->select('lv.id', 'td.columnName', 'td.columnType', 'td.mustFill', 'lv.columnValue')
            ->where('lv.agmtListID', '=', $agmtListID)
            ->where('lv.userID', '=', $userID)
            ->orderBy('lv.agmtTypeColumnID', 'ASC')
            ->get();

        return view('agreement.edit', compact('agmt_list', 'agmt_list_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $agmtListID int  Agreement List ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agmtListID)
    {
        $this->isAuthorize();


        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $this->validate($request, [
            'status' => 'required'
        ]);
        $agmtListData = [
            'status' => $request['status']
        ];
        $agmt_list = Agmt_list::where('id', $agmtListID)->where('userID', '=', $userID)->update($agmtListData);

        $columnSize = sizeof($request['columnID']);
        if ($columnSize > 0) {
            for ($i = 0; $i < $columnSize; $i++) {
                $agmtListDetailsData = [
                    'columnValue' => $request['columnValue'][$i]
                ];
                Agmt_list_value::where('id', '=', $request['columnID'][$i])->where('userID', '=', $userID)->update($agmtListDetailsData);
            }
        }

        $ref_name_size = count($request->ref_name);
        if($ref_name_size > 0){
            for($i = 0 ; $i < $ref_name_size ; $i++){
                $data = [
                    'name' => $request['ref_name'][$i],
                    'agreement_id' => Agmt_list::where('id', $agmtListID)->where('userID', '=', $userID)->first()->id,
                    'company' => $request['ref_company'][$i],
                    'designation' => $request['ref_designation'][$i],
                    'phone' => $request['ref_phone'][$i],
                    'email' => $request['ref_email'][$i]
                ];
               $agreement = Agmt_list::where('id', $agmtListID)->where('userID', '=', $userID)->first();
               $reference = Reference::where(['agreement_id'=>$agreement->id, 'email' => $data['email']])->first();

               if(count($reference) > 0) {
                   $reference->fill($data);
                   $reference->save();
               } else {
                   $reference = $agreement->references()->create($data);
                   Mail::to($reference->email)->send(new TradeEnquiry($reference));
               }
            }
        }

        return redirect('agreement/list')->with('status', 'Successfully Agreement Updated!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $agmtListID int  Agreement List ID
     * @return \Illuminate\Http\Response
     */
    public function upload($agmtListID)
    {
        $this->isAuthorize();

        // Load the Create View
        return view('agreement.upload', compact('agmtListID'));
    }

    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload_store(Request $request)
    {
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $this->validate($request, [
            'uploadFiles' => 'required'
        ]);
        $agmtFilesData = [
            'userID' => $userID,
            'agmtListID' => $request['agmtListID']
        ];
        $uploadID = Agmt_list_upload::create($agmtFilesData)->id;

        $uploadFile = $request->file('uploadFiles');
        $uploadExt = $uploadFile->getClientOriginalExtension();
        $uploadFileName = $uploadID . '.' . $uploadExt;
        $uploadFile->storeAs('agmtUploadFiles', $uploadFileName, 'public');

        $dataUpdate = [
            'fileName' => $uploadFileName
        ];
        Agmt_list_upload::where('ID', $uploadID)->update($dataUpdate);
        return redirect('agreement/list')->with('status', 'Successfully Agreement File Uploaded!');
    }

    /**
     * @param  $agmtListID int  Agreement List ID
     * @return string
     */
    private function raw_pdf($agmtListID)
    {
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $pdf_data = DB::table('agmt_types AS at')
            ->leftJoin('agmt_lists AS al', 'al.agmtTypeID', '=', 'at.id')
            ->select('at.pdfDetails')
            ->where('al.id', '=', $agmtListID)
            ->where('al.userID', '=', $userID)
            ->get()->toArray()[0]->pdfDetails;

        $replace_data = DB::table('agmt_list_values AS lv')
            ->leftJoin('agmt_type_details AS td', 'td.id', '=', 'lv.agmtTypeColumnID')
            ->select('td.id', 'td.placeHolder', 'lv.columnValue')
            ->where('lv.agmtListID', '=', $agmtListID)
            ->where('lv.userID', '=', $userID)
            ->orderBy('lv.agmtTypeColumnID', 'ASC')
            ->get();

        foreach ($replace_data as $key => $value) {
            $pdf_data = str_replace($value->placeHolder, $value->columnValue, $pdf_data);
        }
        return $pdf_data;
    }

    /**
     * @param  $agmtListID int  Agreement List ID
     * @return string
     */
    public function download($agmtListID)
    {
        $this->isAuthorize();

        $raw_pdf = $this->raw_pdf($agmtListID);
        //return view('agreement.pdf', compact('raw_pdf'));
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('agreement.pdf', ['raw_pdf' => $raw_pdf]);
        return $pdf->download('agreement_' . $agmtListID . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $agmtListID int  Agreement List ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($agmtListID)
    {
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $agmt_list = Agmt_list::where('userID', '=', $userID)->where('id', '=', $agmtListID)->firstOrFail();
        $agmt_list->forceDelete();
        return redirect('agreement/list')->with('status', 'Successfully Agreement Deleted!');
    }

    public function askTr($agreement_id)
    {
        $agreement = Agmt_list::find($agreement_id);
        $references = $agreement->references;
        if (count($references) == 0) {
            $email_column = Agmt_type_detail::where(['agmtTypeID' => $agreement->agmtTypeID, 'columnType' => 3])->first();
            $agmt_list_email = Agmt_list_value::where(['agmtListID' => $agreement->id, 'agmtTypeColumnID' => $email_column->id])->first();

            if (isset($agmt_list_email)) {
                $user_email = $agmt_list_email->columnValue;
            } else {
                $user_email = User::whereId($agreement->userID)->first()->email;
            }
            Mail::to($user_email)->send(new \App\Mail\AskedTradeReference($agreement));
        } else {
            foreach ($references as $reference) {
                Mail::to($reference->email)->send(new TradeEnquiry($reference));
            }
            return back()->with('status', 'This agreement already have trade reference. Now enquiry this references.');
        }
        return back()->with('status', 'successfully send this mail');

    }
}
