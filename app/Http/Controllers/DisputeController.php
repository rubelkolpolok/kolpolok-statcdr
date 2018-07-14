<?php

namespace App\Http\Controllers;

use App\Dispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDispute;
use DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Mixed_;
use PhpParser\Node\Expr\Array_;
use Maatwebsite\Excel\Facades\Excel;

class DisputeController extends Controller
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
        return ($userPlan >= 2)? true : abort(404) ;
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
        $allDisputes = Dispute::disputesAll($userID);
        return view("disputes.list", compact('allDisputes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->isAuthorize();

        // Load the Create View
        return view('disputes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDispute  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDispute $request){
        //echo 'munna';die();
        $this->isAuthorize();

        // Insert Data
        if($request['disputeName'] == NULL){
            $disputeName = "AS_";
            $disputeName .= ($request['disputeType'] == 2)?"VDR":"CUST";
            $disputeName .= "_".$request['prtName']."_".$request['fromDate']."_".$request['toDate'];
            $disputeName = str_replace(' ', '_', $disputeName);
            $disputeName = strtoupper($disputeName);
        }else{
            $disputeName = $request['disputeName'];
        }

        $data = [
            'userID'   => $this->request->session()->get('userID'),
            'dType'    => $request['disputeType'],
            'dName'    => $disputeName,
            'prtName'  => $request['prtName'],
            'fromDate' => $request['fromDate'],
            'toDate'   => $request['toDate'],
            'dAmount'  => $request['dAmount'],
            'dueDate'  => $request['dDue'],

            'aDateColNo'     => $request['col1Aaa'],
            'aDateZone'      => $request['col11Aaa'],
            'aCallerColNo'   => $request['col2Aaa'],
            'aCalledColNo'   => $request['col3Aaa'],
            'aCalledPrefix'  => $request['col33Aaa'],
            'aDurationColNo' => $request['col4Aaa'],
            'aDurationType'  => $request['col44Aaa'],
            'aRateColNo'     => $request['col5Aaa'],
            'aCostColNo'     => $request['col6Aaa'],

            'bDateColNo'     => $request['col1Bee'],
            'bDateZone'      => $request['col11Bee'],
            'bCallerColNo'   => $request['col2Bee'],
            'bCalledColNo'   => $request['col3Bee'],
            'bCalledPrefix'  => $request['col33Bee'],
            'bDurationColNo' => $request['col4Bee'],
            'bDurationType'  => $request['col44Bee'],
            'bRateColNo'     => $request['col5Bee'],
            'bCostColNo'     => $request['col6Bee']
        ];

        $disputeID = Dispute::create($data)->id;

        $fileA = $request->file('fileNoA');
        $fileB = $request->file('fileNoB');

        $extA = $fileA->getClientOriginalExtension();
        $extB = $fileB->getClientOriginalExtension();

        $fileNameA  = $disputeID.'a.'.$extA;
        $fileNameB  = $disputeID.'b.'.$extB;

        $fileA->storeAs('disputes', $fileNameA);
        $fileB->storeAs('disputes', $fileNameB);

        $aTblName  = "sdr_".$disputeID."_a";
        $bTblName  = "sdr_".$disputeID."_b";

        $aOriginalFileName = $fileA->getClientOriginalName();
        $bOriginalFileName = $fileB->getClientOriginalName();

        $dataUpdate = [
            'colStatus'  => 1,
            'aTableName' => $aTblName,
            'bTableName' => $bTblName,
            'aFile'      => $fileNameA,
            'bFile'      => $fileNameB,
            'aFileName'  => $aOriginalFileName,
            'bFileName'  => $bOriginalFileName
        ];

        Dispute::where('ID', $disputeID)->update($dataUpdate);

        return redirect('dispute')->with('status', 'Successfully New Dispute Created!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $disputeID int Dispute ID
     * @param $userID int User ID
     * @return Array_
     */
    private function disputeSummeryUpperTable($disputeID, $userID){
        $this->isAuthorize();

        // Get Specific Data
        $disputeDetails = Dispute::disputesDetails($disputeID, $userID)->toArray();

        if($disputeDetails['uploadStatus'] == 1){
            $uploadStatus = '<span class="badge badge-success">Upload DONE</span>';
        }elseif($disputeDetails['uploadStatus'] == -1){
            $uploadStatus = '<span class="badge badge-primary">Currently Uploading</span>';
        }else{
            $uploadStatus = '<span class="badge badge-danger">Upload pending</span>';
        }
        $disputeAmount = isset($disputeDetails['dAmount'])?$disputeDetails['dAmount']:1;
        $disputeTable = [
            'amount'  => $disputeAmount,
            'dispute' => ($disputeDetails['aTotalCost'] - $disputeDetails['bTotalCost']),
            'percent' => ((($disputeDetails['aTotalCost'] - $disputeDetails['bTotalCost'])* 100)/$disputeAmount),
            'status'  => $uploadStatus
        ];

        if($disputeDetails['dType'] == 1){
            $columnTableOne = "Customer";
            $columnTableTwo = "Supplier";
            $columnOne      = "Customer";
            $columnTwo      = "Supplier";
        }else{
            $columnTableOne = "Supplier";
            $columnTableTwo = "Customer";
            $columnOne      = "Supplier";
            $columnTwo      = "Customer";
        }

        $dynamicField = [
            'columnTableOne'  => $columnTableOne,
            'columnTableTwo' => $columnTableTwo,
            'columnOne' => $columnOne,
            'columnTwo'  => $columnTwo
        ];

        return compact('disputeDetails','disputeTable', 'dynamicField');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $disputeID  int Dispute ID
     * @return \Illuminate\Http\Response
     */
    public function summery($disputeID){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $disputeUpperTable = $this->disputeSummeryUpperTable($disputeID, $userID);
        
        $disputeDetails = $disputeUpperTable['disputeDetails'];
        $disputeTable   = $disputeUpperTable['disputeTable'];
        $dynamicField   = $disputeUpperTable['dynamicField'];

        //$tableOne = $disputeDetails['aTableName'];
        //$tableTwo = $disputeDetails['bTableName'];

        // Dispute Script
        //$disputeScript = Dispute::disputeScriptTest($tableOne, $tableTwo);
        //dd($disputeScript);


        $disputes = DB::table("sdr_dispute_summery")
            ->where('userID', '=', $userID)
            ->where('disputeID', '=', $disputeID)
            ->orderBy('disputeType', 'ASC')
            ->get();

        $dispute = $disputes->toArray();
        $disputeDone = sizeof($dispute);

        return view('disputes.summery', compact('disputeDetails','disputeTable', 'dynamicField', 'dispute', 'disputeDone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $disputeID  int Dispute ID
     * @param  $mismatchType  int Dispute Miss Match Type.
     * @return \Illuminate\Http\Response
     */
    public function details($disputeID, $mismatchType){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $disputeUpperTable = $this->disputeSummeryUpperTable($disputeID, $userID);
        $disputeDetails = $disputeUpperTable['disputeDetails'];
        $disputeTable   = $disputeUpperTable['disputeTable'];
        $dynamicField   = $disputeUpperTable['dynamicField'];

        $tableOne = $disputeDetails['aTableName'];
        $tableTwo = $disputeDetails['bTableName'];

        if($mismatchType == 1){
            $mismatchTypeName = 'Exact Match';
            $mismatchData     = Dispute::exactMatchDetails($tableOne, $tableTwo);

        }elseif($mismatchType == 2){
            $mismatchTypeName = 'Mismatch by Billsec(=1Sec)';
            $mismatchData     = Dispute::missMatchOneSecDetails($tableOne, $tableTwo);

        }elseif($mismatchType == 3){
            $mismatchTypeName = 'Mismatch by Billsec(>1Sec)';
            $mismatchData     = Dispute::missMatchGreOneSecDetails($tableOne, $tableTwo);

        }elseif($mismatchType == 4){
            $mismatchTypeName = 'Present in '.$dynamicField['columnOne'] .' CDR Only';
            $mismatchData     = Dispute::onlyATableDetails($tableOne);

        }elseif($mismatchType == 5){
            $mismatchTypeName = 'Present in '.$dynamicField['columnTwo'] .' CDR Only';
            $mismatchData     = Dispute::onlyBTableDetails($tableTwo);

        }else{
            $mismatchTypeName = 'Exact Mismatch';
            $mismatchData     = Dispute::allMissMatch($tableOne, $tableTwo);
        }

        return view('disputes.details', compact('mismatchType','mismatchTypeName', 'mismatchData', 'disputeDetails','disputeTable', 'dynamicField'));
    }

    private function multi_rename_key(&$array, $old_keys, $new_keys){
        if(!is_array($array)){
            ($array=="") ? $array=array() : false;
            return $array;
        }
        foreach($array as &$arr){
            if(is_array($old_keys)){
                foreach($new_keys as $k => $new_key){
                    (isset($old_keys[$k])) ? true : $old_keys[$k]=NULL;
                    $arr[$new_key] = (isset($arr[$old_keys[$k]]) ? $arr[$old_keys[$k]] : null);
                    unset($arr[$old_keys[$k]]);
                }
            }else{
                $arr[$new_keys] = (isset($arr[$old_keys]) ? $arr[$old_keys] : null);
                unset($arr[$old_keys]);
            }
        }
        return $array;
    }

    /**
     * Export Disputes.
     *
     * @param  $disputeID  int Dispute ID
     * @param  $mismatchType  int Dispute Miss Match Type.
     * @return \Illuminate\Http\Response
     */
    public function export($disputeID, $mismatchType){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');
        $disputeUpperTable = $this->disputeSummeryUpperTable($disputeID, $userID);
        $disputeDetails    = $disputeUpperTable['disputeDetails'];
        $dynamicField      = $disputeUpperTable['dynamicField'];

        $tableOne = $disputeDetails['aTableName'];
        $tableTwo = $disputeDetails['bTableName'];

        if($mismatchType == 1){
            $mismatchTypeName = 'Exact Match';
            $mismatchData     = Dispute::excelOne($tableOne, $tableTwo);

        }elseif($mismatchType == 2){
            $mismatchTypeName = 'Mismatch by Billsec(=1Sec)';
            $mismatchData     = Dispute::excelTwo($tableOne, $tableTwo);

        }elseif($mismatchType == 3){
            $mismatchTypeName = 'Mismatch by Billsec(>1Sec)';
            $mismatchData     = Dispute::excelThree($tableOne, $tableTwo);

        }elseif($mismatchType == 4){
            $mismatchTypeName = 'Present in '.$dynamicField['columnOne'] .' CDR Only';
            $mismatchData     = Dispute::excelFour($tableOne);

        }elseif($mismatchType == 5){
            $mismatchTypeName = 'Present in '.$dynamicField['columnTwo'] .' CDR Only';
            $mismatchData     = Dispute::excelFive($tableTwo);

        }else{
            $mismatchTypeName = 'Exact Mismatch';
            $mismatchData     = Dispute::excelSix($tableOne, $tableTwo);
        }

        $mismatchData = json_decode(json_encode($mismatchData),true);

        Excel::create('disputeData - '.$mismatchTypeName, function($excel) use($mismatchData, $dynamicField) {
            $excel->sheet('Dispute Data', function($sheet) use($mismatchData, $dynamicField) {

                $this->multi_rename_key($mismatchData, array("A1","A2","A3","A4","B1","delta"), array("Called Time", "Call Form", "Call To", $dynamicField['columnTableOne']." (Sec)", $dynamicField['columnTableTwo']." (Sec)", "Delta (Sec)"));

                $sheet->fromArray($mismatchData, null, 'A1', true);
            });
        })->download('xls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $disputeID int Dispute ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($disputeID){
        $this->isAuthorize();

        // Get Specific Data
        $userID = $this->request->session()->get('userID');

        //DROP Export Excel Data from database - START
        $disputeUpperTable = $this->disputeSummeryUpperTable($disputeID, $userID);
        $disputeDetails = $disputeUpperTable['disputeDetails'];

        Schema::dropIfExists($disputeDetails['aTableName']);
        Schema::dropIfExists($disputeDetails['bTableName']);
        //DROP Export Excel Data from database - END

        DB::table('sdr_dispute_summery')->where('disputeID', '=', $disputeID)->where('userID', '=', $userID)->delete();
        DB::table('disputes')->where('ID', '=', $disputeID)->where('userID', '=', $userID)->delete();

        return redirect('dispute')->with('status', 'Successfully Dispute Deleted!');
    }
}
