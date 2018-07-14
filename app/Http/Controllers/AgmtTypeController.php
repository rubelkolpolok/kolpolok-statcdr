<?php

namespace App\Http\Controllers;

use App\Agmt_type;
use App\Agmt_type_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgmtTypeController extends Controller
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
        $allAgmtTypes = Agmt_type::where('userID','=',$userID)->orderBy('id','DESC')->paginate(10);
        return view('agreement.type.index', compact('allAgmtTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->isAuthorize();

        // Load the Create View
        return view('agreement.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->isAuthorize();

        // Insert Data
        $this->validate($request, [
            'typeName' => 'required',
            'adminApprove' => 'required',
            'pdfDetails' => 'required',
            'showOrder' => 'required|integer'
        ]);

        $agmtTypeData = [
            'userID'       => $this->request->session()->get('userID'),
            'typeName'     => $request['typeName'],
            'adminApprove' => $request['adminApprove'],
            'pdfDetails'   => $request['pdfDetails'],
            'showOrder'    => $request['showOrder']
        ];

        $agmtTypeID = Agmt_type::create($agmtTypeData)->id;

        $columnSize = sizeof($request['columnName']);
        if($columnSize > 1){
            for($i = 1 ; $i < $columnSize ; $i++){
                $agmtTypeDetailsData = [
                    'userID'      => $this->request->session()->get('userID'),
                    'agmtTypeID'  => $agmtTypeID,
                    'columnName'  => $request['columnName'][$i],
                    'placeHolder' => $request['placeHolder'][$i],
                    'columnType'  => $request['columnType'][$i],
                    'mustFill'    => $request['mustFill'][$i]
                ];
                Agmt_type_detail::create($agmtTypeDetailsData);
            }
        }
        return redirect('agreement/type')->with('status', 'Successfully New Agreement Type Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $agmtTypeID int  Agreement Type ID
     * @return \Illuminate\Http\Response
     */
    public function edit($agmtTypeID){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $agmt_type         = Agmt_type::where('userID','=',$userID)->where('id','=',$agmtTypeID)->firstOrFail();
        $agmt_type_details = Agmt_type_detail::where('userID','=',$userID)->where('agmtTypeID','=',$agmtTypeID)->get()->toArray();
        return view('agreement.type.edit', compact('agmt_type','agmt_type_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $agmtTypeID int  Agreement Type ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agmtTypeID){
        $this->isAuthorize();

        // Update the Specific Data
        $userID = $this->request->session()->get('userID');
        $this->validate($request, [
            'typeName' => 'required',
            'adminApprove' => 'required',
            'pdfDetails' => 'required',
            'showOrder' => 'required|integer'
        ]);

        $agmtTypeData = [
            'typeName'     => $request['typeName'],
            'adminApprove' => $request['adminApprove'],
            'pdfDetails'   => $request['pdfDetails'],
            'showOrder'    => $request['showOrder']
        ];

        Agmt_type::where('id', '=', $agmtTypeID)->where('userID', '=', $userID)->update($agmtTypeData);

        $columnSize = sizeof($request['columnName']);
        if($columnSize > 1){
            for($i = 1 ; $i < $columnSize ; $i++){
                $agmtTypeDetailsData = [
                    'agmtTypeID'  => $agmtTypeID,
                    'columnName'  => $request['columnName'][$i],
                    'placeHolder' => $request['placeHolder'][$i],
                    'columnType'  => $request['columnType'][$i],
                    'mustFill'    => $request['mustFill'][$i]
                ];
                Agmt_type_detail::where('id', '=', $request['columnID'][$i])->where('userID', '=', $userID)->update($agmtTypeDetailsData);
            }
        }
        return redirect('agreement/type')->with('status', 'Successfully Agreement Type Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $agmtTypeID int  Agreement Type ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($agmtTypeID){
        $this->isAuthorize();

        // Delete the Specific Data
        $userID = $this->request->session()->get('userID');
        $agmt_type = Agmt_type::where('userID','=',$userID)->where('id','=',$agmtTypeID)->firstOrFail();
        $agmt_type->forceDelete();
        return redirect('agreement/type')->with('status', 'Successfully Agreement Type Deleted!');
    }
}
