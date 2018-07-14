<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dispute extends Model
{
    protected $fillable = [
        'userID',
        'dType',
        'dName',
        'prtName',
        'fromDate',
        'toDate',
        'dAmount',
        'dueDate',

        'aDateColNo',
        'aDateZone',
        'aCallerColNo',
        'aCalledColNo',
        'aCalledPrefix',
        'aDurationColNo',
        'aDurationType',
        'aRateColNo',
        'aCostColNo',

        'bDateColNo',
        'bDateZone',
        'bCallerColNo',
        'bCalledColNo',
        'bCalledPrefix',
        'bDurationColNo',
        'bDurationType',
        'bRateColNo',
        'bCostColNo'
    ];

    /**
     * Display a listing of the All resource.
     *
     * @param $query object Query Object
     * @param $userID int User ID
     * @return object
     */
    public function scopeDisputesAll($query, $userID){
        return $query->where('userID','=',$userID)->orderBy('id','DESC')->get();
    }

    /**
     * Disputes Details.
     *
     * @param $query object Query Object
     * @param $disputeID  int Dispute ID
     * @param $userID int User ID
     * @return object
     */
    public function scopeDisputesDetails($query, $disputeID, $userID){
        return $query->select(DB::raw('*'))->where([['ID', '=', $disputeID],['userID', '=', $userID]])->firstOrFail();
    }

    public function scopeDisputeScriptTest($query, $tableOne, $tableTwo){
        $tableA = DB::table($tableOne)
                        ->selectRaw('calledNo')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableB = DB::table($tableTwo)
                        ->selectRaw('calledNo')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableAD = DB::table($tableOne)
                        ->selectRaw('calledNo, duration')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableBD = DB::table($tableTwo)
                        ->selectRaw('calledNo, duration')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $match       = 0;
        $match_1_sec = 0;
        $match_2_sec = 0;
        $only_A      = 0;
        $only_B      = 0;

        for($i = 0 ; isset($tableA[0]->calledNo) ; $i++){

            // Checking : Exact Match.
            if(
                (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo) && isset($tableAD[0]->duration) && isset($tableBD[0]->duration)) &&
                (($tableA[0]->calledNo == $tableB[0]->calledNo) && ($tableAD[0]->duration == $tableBD[0]->duration))
            ){
                $match++;

                echo $i." - Exact Match - ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br>";

                $tableA  = array_slice($tableA,1);
                $tableB  = array_slice($tableB,1);
                $tableAD = array_slice($tableAD,1);
                $tableBD = array_slice($tableBD,1);

                // Partially Match or Full Dispute
            }else{

                echo "<br>".$tableA[0]->calledNo." - ".$tableB[0]->calledNo."<br>";
                // Checking : Called No.
                if(
                    (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo)) &&
                    (($tableA[0]->calledNo == $tableB[0]->calledNo))
                ){

                    // Checking : Dispute is 1 SEC.
                    if(abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) == 1){
                        $match_1_sec++;

                        echo $i." - 1 Sec - ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                        $tableA  = array_slice($tableA,1);
                        $tableB  = array_slice($tableB,1);
                        $tableAD = array_slice($tableAD,1);
                        $tableBD = array_slice($tableBD,1);

                        // Checking : Dispute is > 1 SEC.
                    }elseif((abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) > 1)){
                        $findA = array_search($tableA[0], $tableB);
                        $findB = array_search($tableB[0], $tableA);

                        echo "Called Number : ".$findA."-".$findB."<br>";

                        if(($findA != '') && (($findB == ''))){
                            $only_B += 1;

                            echo $i." - Only B : - ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                            $tableB  = array_slice($tableB,1);
                            $tableBD = array_slice($tableBD,1);

                        }elseif(($findA == '') && (($findB != ''))){
                            $only_A += 1;

                            echo $i." - Only A : - ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                            $tableA  = array_slice($tableA,1);
                            $tableAD = array_slice($tableAD,1);

                        }elseif(($findA == '') && (($findB == ''))){
                            $findAD = array_search($tableAD[0], $tableBD);
                            $findBD = array_search($tableBD[0], $tableAD);

                            echo "Duration : ".$findAD."-".$findBD."<br>";

                            if(($findAD != '') && (($findBD == ''))){
                                $only_B += 1;

                                echo $i." - Only B : 3 - ".$findAD." - Delete From B ".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                                $tableB  = array_slice($tableB,1);
                                $tableBD = array_slice($tableBD,1);

                            }elseif(($findAD == '') && (($findBD != ''))){
                                $only_A += 1;

                                echo $i." - Only A : 3 - ".$findBD." - Delete From A ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."<br><br>";

                                $tableA  = array_slice($tableA,1);
                                $tableAD = array_slice($tableAD,1);

                            }else{
                                $match_2_sec++;

                                echo $i." - > 1 Sec : ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                                $tableA  = array_slice($tableA, 1);
                                $tableB  = array_slice($tableB, 1);
                                $tableAD = array_slice($tableAD, 1);
                                $tableBD = array_slice($tableBD, 1);

                            }

                        }else{
                            $match++;

                            echo $i." 2 - Exact Match - ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."---".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                            $tableA  = array_slice($tableA,1);
                            $tableB  = array_slice($tableB,1);
                            $tableAD = array_slice($tableAD,1);
                            $tableBD = array_slice($tableBD,1);
                        }
                    }

                    // Full Dispute
                }else{
                    if(isset($tableA[0])){
                        $findA = array_search($tableA[0], $tableB);
                    }else{
                        $findA = '';
                    }

                    if(isset($tableB[0])){
                        $findB = array_search($tableB[0], $tableA);
                    }else{
                        $findB = '';
                    }

                    if(($findA != '') && (($findB == ''))){
                        $only_B += $findA;

                        echo $i." - Only B : 2 - ".$findA." - Delete From B ".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                        $tableB  = array_slice($tableB, $findA);
                        $tableBD = array_slice($tableBD, $findA);

                    }elseif(($findA == '') && (($findB != ''))){
                        $only_A += $findB;

                        echo $i." - Only A : 2 - ".$findB." - Delete From A ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."<br><br>";

                        $tableA  = array_slice($tableA, $findB);
                        $tableAD = array_slice($tableAD, $findB);

                    }elseif(($findA == '') && (($findB == ''))){

                        if(isset($tableA[0]->calledNo)){
                            $only_A += 1;

                            echo $i." - Only A : 2Double - Delete From A ".$tableA[0]->calledNo." : ".$tableAD[0]->duration."<br>";

                            $tableA  = array_slice($tableA, 1);
                            $tableAD = array_slice($tableAD, 1);
                        }

                        if(isset($tableB[0]->calledNo)){
                            $only_B += 1;

                            echo $i." - Only B : 2Double - Delete From B ".$tableB[0]->calledNo." : ".$tableBD[0]->duration."<br><br>";

                            $tableB  = array_slice($tableB,1);
                            $tableBD = array_slice($tableBD,1);
                        }
                    }
                }
            }
        }
        echo "Exact Match : ".$match."<br>";
        echo "Mismatch by 1 SEC : ".$match_1_sec."<br>";
        echo "Mismatch by > 1 SEC : ".$match_2_sec."<br>";
        echo "Only A : ".$only_A."<br>";
        echo "Only B : ".$only_B."<br>";
        exit;
    }

    /**
     * Disputes Script.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeDisputeScript($query, $tableOne, $tableTwo){
        $tableA = DB::table($tableOne)
                        ->selectRaw('calledNo')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableB = DB::table($tableTwo)
                        ->selectRaw('calledNo')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableAD = DB::table($tableOne)
                        ->selectRaw('calledNo, duration')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableBD = DB::table($tableTwo)
                        ->selectRaw('calledNo, duration')
                        ->orderByRaw('calledNo, duration * 1 DESC')
                        ->get()->toArray();

        $tableAExtra = DB::table($tableOne)
                            ->selectRaw('ID, callCost')
                            ->orderByRaw('calledNo, duration * 1 DESC')
                            ->get()->toArray();

        $tableBExtra = DB::table($tableTwo)
                            ->selectRaw('ID, callCost')
                            ->orderByRaw('calledNo, duration * 1 DESC')
                            ->get()->toArray();

        $secA['1'] = 0;
        $secA['2'] = 0;
        $secA['3'] = 0;
        $secA['4'] = 0;
        $secA['5'] = 0;
        $costA['1'] = 0;
        $costA['2'] = 0;
        $costA['3'] = 0;
        $costA['4'] = 0;
        $costA['5'] = 0;

        $secB['1'] = 0;
        $secB['2'] = 0;
        $secB['3'] = 0;
        $secB['4'] = 0;
        $secB['5'] = 0;
        $costB['1'] = 0;
        $costB['2'] = 0;
        $costB['3'] = 0;
        $costB['4'] = 0;
        $costB['5'] = 0;

        $match       = 0;
        $match_1_sec = 0;
        $match_2_sec = 0;
        $only_A      = 0;
        $only_B      = 0;

        $tASize = sizeof($tableA);
        $tBSize = sizeof($tableB);

        if($tASize > $tBSize){
            for($i = 0 ; isset($tableA[0]->calledNo) ; $i++){

                // Checking : Exact Match.
                if(
                    (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo) && isset($tableAD[0]->duration) && isset($tableBD[0]->duration)) &&
                    (($tableA[0]->calledNo == $tableB[0]->calledNo) && ($tableAD[0]->duration == $tableBD[0]->duration))
                ){
                    $match++;

                    $secA['1']  += $tableAD[0]->duration;
                    $secB['1']  += $tableBD[0]->duration;
                    $costA['1'] += $tableAExtra[0]->callCost;
                    $costB['1'] += $tableBExtra[0]->callCost;

                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 1, 'bTableID' => $tableBExtra[0]->ID]);
                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 1]);

                    $tableA      = array_slice($tableA,1);
                    $tableB      = array_slice($tableB,1);
                    $tableAD     = array_slice($tableAD,1);
                    $tableBD     = array_slice($tableBD,1);
                    $tableAExtra = array_slice($tableAExtra,1);
                    $tableBExtra = array_slice($tableBExtra,1);

                    // Partially Match or Full Dispute
                }else{

                    // Checking : Same Called No.
                    if(
                        (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo)) &&
                        (($tableA[0]->calledNo == $tableB[0]->calledNo))
                    ){

                        // Checking : Dispute is 1 SEC.
                        if(abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) == 1){
                            $match_1_sec++;

                            $secA['2']  += $tableAD[0]->duration;
                            $secB['2']  += $tableBD[0]->duration;
                            $costA['2'] += $tableAExtra[0]->callCost;
                            $costB['2'] += $tableBExtra[0]->callCost;

                            DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 2, 'bTableID' => $tableBExtra[0]->ID]);
                            DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 2]);

                            $tableA      = array_slice($tableA,1);
                            $tableB      = array_slice($tableB,1);
                            $tableAD     = array_slice($tableAD,1);
                            $tableBD     = array_slice($tableBD,1);
                            $tableAExtra = array_slice($tableAExtra,1);
                            $tableBExtra = array_slice($tableBExtra,1);

                            // Checking : Dispute is > 1 SEC.
                        }elseif((abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) > 1)){
                            $findA = array_search($tableA[0], $tableB);
                            $findB = array_search($tableB[0], $tableA);

                            if(($findA != '') && (($findB == ''))){
                                $only_B += 1;

                                $secB['5']  += $tableBD[0]->duration;
                                $costB['5'] += $tableBExtra[0]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                $tableB      = array_slice($tableB,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableBExtra = array_slice($tableBExtra, 1);

                            }elseif(($findA == '') && (($findB != ''))){
                                $only_A += 1;

                                $secA['4']  += $tableAD[0]->duration;
                                $costA['4'] += $tableAExtra[0]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                $tableA      = array_slice($tableA,1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableAExtra = array_slice($tableAExtra, 1);

                            }elseif(($findA == '') && (($findB == ''))){

                                $findAD = array_search($tableAD[0], $tableBD);
                                $findBD = array_search($tableBD[0], $tableAD);

                                if(($findAD != '') && (($findBD == ''))){
                                    $only_B += 1;

                                    $secB['5']  += $tableBD[0]->duration;
                                    $costB['5'] += $tableBExtra[0]->callCost;
                                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                    $tableB      = array_slice($tableB,1);
                                    $tableBD     = array_slice($tableBD,1);
                                    $tableBExtra = array_slice($tableBExtra, 1);

                                }elseif(($findAD == '') && (($findBD != ''))){
                                    $only_A += 1;

                                    $secA['4']  += $tableAD[0]->duration;
                                    $costA['4'] += $tableAExtra[0]->callCost;
                                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                    $tableA      = array_slice($tableA,1);
                                    $tableAD     = array_slice($tableAD,1);
                                    $tableAExtra = array_slice($tableAExtra, 1);

                                }else{
                                    $match_2_sec++;

                                    $secA['3']  += $tableAD[0]->duration;
                                    $secB['3']  += $tableBD[0]->duration;
                                    $costA['3'] += $tableAExtra[0]->callCost;
                                    $costB['3'] += $tableBExtra[0]->callCost;

                                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 3, 'bTableID' => $tableBExtra[0]->ID]);
                                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 3]);

                                    $tableA      = array_slice($tableA, 1);
                                    $tableB      = array_slice($tableB, 1);
                                    $tableAD     = array_slice($tableAD,1);
                                    $tableBD     = array_slice($tableBD,1);
                                    $tableAExtra = array_slice($tableAExtra,1);
                                    $tableBExtra = array_slice($tableBExtra,1);
                                }

                            }else{
                                $match++;

                                $secA['1']  += $tableAD[0]->duration;
                                $secB['1']  += $tableBD[0]->duration;
                                $costA['1'] += $tableAExtra[0]->callCost;
                                $costB['1'] += $tableBExtra[0]->callCost;

                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 1, 'bTableID' => $tableBExtra[0]->ID]);
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 1]);

                                $tableA      = array_slice($tableA,1);
                                $tableB      = array_slice($tableB,1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableAExtra = array_slice($tableAExtra,1);
                                $tableBExtra = array_slice($tableBExtra,1);
                            }
                        }

                        // Full Dispute
                    }else{
                        if(isset($tableA[0])){
                            $findA = array_search($tableA[0], $tableB);
                        }else{
                            $findA = '';
                        }

                        if(isset($tableB[0])){
                            $findB = array_search($tableB[0], $tableA);
                        }else{
                            $findB = '';
                        }

                        if(($findA != '') && (($findB == ''))){
                            $only_B += $findA;

                            for($inner = 0 ; $inner < $findA ; $inner++){
                                $secB['5']  += $tableBD[$inner]->duration;
                                $costB['5'] += $tableBExtra[$inner]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[$inner]->ID)->update(['disType' => 5]);
                            }

                            $tableB      = array_slice($tableB, $findA);
                            $tableBD     = array_slice($tableBD,$findA);
                            $tableBExtra = array_slice($tableBExtra, $findA);

                        }elseif(($findA == '') && (($findB != ''))){
                            $only_A += $findB;

                            for($inner = 0 ; $inner < $findB ; $inner++){
                                $secA['4']  += $tableAD[$inner]->duration;
                                $costA['4'] += $tableAExtra[$inner]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[$inner]->ID)->update(['disType' => 4]);
                            }

                            $tableA      = array_slice($tableA, $findB);
                            $tableAD     = array_slice($tableAD, $findB);
                            $tableAExtra = array_slice($tableAExtra, $findB);

                        }elseif(($findA == '') && (($findB == ''))){

                            if(isset($tableA[0]->calledNo)){
                                $only_A += 1;

                                $secA['4']  += $tableAD[0]->duration;
                                $costA['4'] += $tableAExtra[0]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                $tableA      = array_slice($tableA, 1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableAExtra = array_slice($tableAExtra,1);
                            }


                            if(isset($tableB[0]->calledNo)){
                                $only_B += 1;

                                $secB['5']  += $tableBD[0]->duration;
                                $costB['5'] += $tableBExtra[0]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                $tableB      = array_slice($tableB,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableBExtra = array_slice($tableBExtra,1);
                            }
                        }
                    }
                }
            }

        }else{
            for($i = 0 ; isset($tableB[0]->calledNo) ; $i++){

                // Checking : Exact Match.
                if(
                    (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo) && isset($tableAD[0]->duration) && isset($tableBD[0]->duration)) &&
                    (($tableA[0]->calledNo == $tableB[0]->calledNo) && ($tableAD[0]->duration == $tableBD[0]->duration))
                ){
                    $match++;

                    $secA['1']  += $tableAD[0]->duration;
                    $secB['1']  += $tableBD[0]->duration;
                    $costA['1'] += $tableAExtra[0]->callCost;
                    $costB['1'] += $tableBExtra[0]->callCost;

                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 1, 'bTableID' => $tableBExtra[0]->ID]);
                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 1]);

                    $tableA      = array_slice($tableA,1);
                    $tableB      = array_slice($tableB,1);
                    $tableAD     = array_slice($tableAD,1);
                    $tableBD     = array_slice($tableBD,1);
                    $tableAExtra = array_slice($tableAExtra,1);
                    $tableBExtra = array_slice($tableBExtra,1);

                    // Partially Match or Full Dispute
                }else{

                    // Checking : Same Called No.
                    if(
                        (isset($tableA[0]->calledNo) && isset($tableB[0]->calledNo)) &&
                        (($tableA[0]->calledNo == $tableB[0]->calledNo))
                    ){

                        // Checking : Dispute is 1 SEC.
                        if(abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) == 1){
                            $match_1_sec++;

                            $secA['2']  += $tableAD[0]->duration;
                            $secB['2']  += $tableBD[0]->duration;
                            $costA['2'] += $tableAExtra[0]->callCost;
                            $costB['2'] += $tableBExtra[0]->callCost;

                            DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 2, 'bTableID' => $tableBExtra[0]->ID]);
                            DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 2]);

                            $tableA      = array_slice($tableA,1);
                            $tableB      = array_slice($tableB,1);
                            $tableAD     = array_slice($tableAD,1);
                            $tableBD     = array_slice($tableBD,1);
                            $tableAExtra = array_slice($tableAExtra,1);
                            $tableBExtra = array_slice($tableBExtra,1);

                            // Checking : Dispute is > 1 SEC.
                        }elseif((abs((int)($tableAD[0]->duration) - (int)($tableBD[0]->duration)) > 1)){
                            $findA = array_search($tableA[0], $tableB);
                            $findB = array_search($tableB[0], $tableA);

                            if(($findA != '') && (($findB == ''))){
                                $only_B += 1;

                                $secB['5']  += $tableBD[0]->duration;
                                $costB['5'] += $tableBExtra[0]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                $tableB      = array_slice($tableB,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableBExtra = array_slice($tableBExtra, 1);

                            }elseif(($findA == '') && (($findB != ''))){
                                $only_A += 1;

                                $secA['4']  += $tableAD[0]->duration;
                                $costA['4'] += $tableAExtra[0]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                $tableA      = array_slice($tableA,1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableAExtra = array_slice($tableAExtra, 1);

                            }elseif(($findA == '') && (($findB == ''))){

                                $findAD = array_search($tableAD[0], $tableBD);
                                $findBD = array_search($tableBD[0], $tableAD);

                                if(($findAD != '') && (($findBD == ''))){
                                    $only_B += 1;

                                    $secB['5']  += $tableBD[0]->duration;
                                    $costB['5'] += $tableBExtra[0]->callCost;
                                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                    $tableB      = array_slice($tableB,1);
                                    $tableBD     = array_slice($tableBD,1);
                                    $tableBExtra = array_slice($tableBExtra, 1);

                                }elseif(($findAD == '') && (($findBD != ''))){
                                    $only_A += 1;

                                    $secA['4']  += $tableAD[0]->duration;
                                    $costA['4'] += $tableAExtra[0]->callCost;
                                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                    $tableA      = array_slice($tableA,1);
                                    $tableAD     = array_slice($tableAD,1);
                                    $tableAExtra = array_slice($tableAExtra, 1);

                                }else{
                                    $match_2_sec++;

                                    $secA['3']  += $tableAD[0]->duration;
                                    $secB['3']  += $tableBD[0]->duration;
                                    $costA['3'] += $tableAExtra[0]->callCost;
                                    $costB['3'] += $tableBExtra[0]->callCost;

                                    DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 3, 'bTableID' => $tableBExtra[0]->ID]);
                                    DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 3]);

                                    $tableA      = array_slice($tableA, 1);
                                    $tableB      = array_slice($tableB, 1);
                                    $tableAD     = array_slice($tableAD,1);
                                    $tableBD     = array_slice($tableBD,1);
                                    $tableAExtra = array_slice($tableAExtra,1);
                                    $tableBExtra = array_slice($tableBExtra,1);
                                }

                            }else{
                                $match++;

                                $secA['1']  += $tableAD[0]->duration;
                                $secB['1']  += $tableBD[0]->duration;
                                $costA['1'] += $tableAExtra[0]->callCost;
                                $costB['1'] += $tableBExtra[0]->callCost;

                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 1, 'bTableID' => $tableBExtra[0]->ID]);
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 1]);

                                $tableA      = array_slice($tableA,1);
                                $tableB      = array_slice($tableB,1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableAExtra = array_slice($tableAExtra,1);
                                $tableBExtra = array_slice($tableBExtra,1);
                            }
                        }

                        // Full Dispute
                    }else{
                        if(isset($tableA[0])){
                            $findA = array_search($tableA[0], $tableB);
                        }else{
                            $findA = '';
                        }

                        if(isset($tableB[0])){
                            $findB = array_search($tableB[0], $tableA);
                        }else{
                            $findB = '';
                        }

                        if(($findA != '') && (($findB == ''))){
                            $only_B += $findA;

                            for($inner = 0 ; $inner < $findA ; $inner++){
                                $secB['5']  += $tableBD[$inner]->duration;
                                $costB['5'] += $tableBExtra[$inner]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[$inner]->ID)->update(['disType' => 5]);
                            }

                            $tableB      = array_slice($tableB, $findA);
                            $tableBD     = array_slice($tableBD,$findA);
                            $tableBExtra = array_slice($tableBExtra, $findA);

                        }elseif(($findA == '') && (($findB != ''))){
                            $only_A += $findB;

                            for($inner = 0 ; $inner < $findB ; $inner++){
                                $secA['4']  += $tableAD[$inner]->duration;
                                $costA['4'] += $tableAExtra[$inner]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[$inner]->ID)->update(['disType' => 4]);
                            }

                            $tableA      = array_slice($tableA, $findB);
                            $tableAD     = array_slice($tableAD, $findB);
                            $tableAExtra = array_slice($tableAExtra, $findB);

                        }elseif(($findA == '') && (($findB == ''))){

                            if(isset($tableA[0]->calledNo)){
                                $only_A += 1;

                                $secA['4']  += $tableAD[0]->duration;
                                $costA['4'] += $tableAExtra[0]->callCost;
                                DB::table($tableOne)->where('ID', $tableAExtra[0]->ID)->update(['disType' => 4]);

                                $tableA      = array_slice($tableA, 1);
                                $tableAD     = array_slice($tableAD,1);
                                $tableAExtra = array_slice($tableAExtra,1);
                            }


                            if(isset($tableB[0]->calledNo)){
                                $only_B += 1;

                                $secB['5']  += $tableBD[0]->duration;
                                $costB['5'] += $tableBExtra[0]->callCost;
                                DB::table($tableTwo)->where('ID', $tableBExtra[0]->ID)->update(['disType' => 5]);

                                $tableB      = array_slice($tableB,1);
                                $tableBD     = array_slice($tableBD,1);
                                $tableBExtra = array_slice($tableBExtra,1);
                            }
                        }
                    }
                }
            }
        }
        $array['1'] = [$match,$secA['1'],$secB['1'],$costA['1'],$costB['1']];
        $array['2'] = [$match_1_sec,$secA['2'],$secB['2'],$costA['2'],$costB['2']];
        $array['3'] = [$match_2_sec,$secA['3'],$secB['3'],$costA['3'],$costB['3']];
        $array['4'] = [$only_A,$secA['4'],$secB['4'],$costA['4'],$costB['4']];
        $array['5'] = [$only_B,$secA['5'],$secB['5'],$costA['5'],$costB['5']];

        return $array;
    }

    /**
     * Disputes Exact Match Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeExactMatchDetails($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1')
                    ->whereRaw('Aaa.disType = 1')
                    ->orderByRaw('Aaa.callTime ASC, Aaa.calledNo, Aaa.duration')
                    ->paginate(10);
    }

    /**
     * Disputes Match By 1 SEC Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeMissMatchOneSecDetails($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1')
                    ->whereRaw('Aaa.disType = 2')
                    ->orderByRaw('Aaa.callTime ASC, Aaa.calledNo, Aaa.duration')
                    ->paginate(10);
    }

    /**
     * Disputes Match By 2 SEC Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeMissMatchGreOneSecDetails($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1')
                    ->whereRaw('Aaa.disType = 3')
                    ->orderByRaw('Aaa.callTime ASC, Aaa.calledNo, Aaa.duration')
                    ->paginate(10);
    }

    /**
     * Disputes Table A CDR Only Data.
     *
     * @param $query object Query Object
     * @param  $table string Table
     * @return object
     */
    public function scopeOnlyATableDetails($query, $table){
        return DB::table($table)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, 0 AS B1')
                    ->whereRaw('disType = 4')
                    ->orderByRaw('callTime ASC, calledNo, duration')
                    ->paginate(10);
    }

    /**
     * Disputes Table B CDR Only Data.
     *
     * @param $query object Query Object
     * @param  $table string Table
     * @return object
     */
    public function scopeOnlyBTableDetails($query, $table){
        return DB::table($table)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, 0 AS B1')
                    ->whereRaw('disType = 5')
                    ->orderByRaw('callTime ASC, calledNo, duration')
                    ->paginate(10);
    }

    /**
     * Disputes All Mismatch Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeAllMissMatch($query, $tableOne, $tableTwo){
        $one_sec = DB::table($tableOne." AS Aaa")
                        ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                        ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1')
                        ->whereRaw('Aaa.disType = 2');

        $two_sec = DB::table($tableOne." AS Aaa")
                        ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                        ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1')
                        ->whereRaw('Aaa.disType = 3');

        $only_table_A = DB::table($tableOne)
                            ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, 0 AS B1')
                            ->whereRaw('disType = 4');

        return DB::table($tableTwo)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, "zyz" AS B1')
                    ->whereRaw('disType = 5')
                    ->unionAll($one_sec)
                    ->unionAll($two_sec)
                    ->unionAll($only_table_A)
                    ->orderByRaw('A3, A4')
                    ->get();
    }

    /**
     * Disputes Exact Match Excel Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeExcelOne($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1, 0 as delta')
                    ->whereRaw('Aaa.disType = 1')
                    ->orderByRaw('A1, A3, A4')
                    ->get();
    }

    /**
     * Disputes Match By 1 SEC Excel Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeExcelTwo($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1, (Aaa.duration - Bee.duration) as delta')
                    ->whereRaw('Aaa.disType = 2')
                    ->orderByRaw('A1, A3, A4')
                    ->get();
    }

    /**
     * Disputes Match By 2 SEC Excel Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeExcelThree($query, $tableOne, $tableTwo){
        return DB::table($tableOne." AS Aaa")
                    ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                    ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1, (Aaa.duration - Bee.duration) as delta')
                    ->whereRaw('Aaa.disType = 3')
                    ->orderByRaw('A1, A3, A4')
                    ->get();
    }

    /**
     * Disputes Table A CDR Only Excel Data.
     *
     * @param $query object Query Object
     * @param  $table string Table
     * @return object
     */
    public function scopeExcelFour($query, $table){
        return DB::table($table)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, 0 AS B1, duration as delta')
                    ->whereRaw('disType = 4')
                    ->orderByRaw('A1, A3, A4')
                    ->get();
    }

    /**
     * Disputes Table B CDR Only Excel Data.
     *
     * @param $query object Query Object
     * @param  $table string Table
     * @return object
     */
    public function scopeExcelFive($query, $table){
        return DB::table($table)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, 0 AS A4, duration AS B1, duration as delta')
                    ->whereRaw('disType = 5')
                    ->orderByRaw('A1, A3, B1')
                    ->get();
    }

    /**
     * Disputes All Mismatch Excel Data.
     *
     * @param $query object Query Object
     * @param  $tableOne  string Table One
     * @param  $tableTwo  string Table Two
     * @return object
     */
    public function scopeExcelSix($query, $tableOne, $tableTwo){
        $one_sec = DB::table($tableOne." AS Aaa")
                        ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                        ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1, (Aaa.duration - Bee.duration) as delta')
                        ->whereRaw('Aaa.disType = 2');

        $two_sec = DB::table($tableOne." AS Aaa")
                        ->leftJoin($tableTwo." AS Bee",'Aaa.bTableID','=','Bee.ID')
                        ->selectRaw('Aaa.callTime AS A1, Aaa.callerNo AS A2, Aaa.calledNo AS A3, Aaa.duration AS A4, Bee.duration AS B1, (Aaa.duration - Bee.duration) as delta')
                        ->whereRaw('Aaa.disType = 3');

        $only_table_A = DB::table($tableOne)
                            ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, duration AS A4, 0 AS B1, (duration - 0) as delta')
                            ->whereRaw('disType = 4');

        return DB::table($tableTwo)
                    ->selectRaw('callTime AS A1, callerNo AS A2, calledNo AS A3, 0 AS A4, duration AS B1, (0 - duration) as delta')
                    ->whereRaw('disType = 5')
                    ->unionAll($one_sec)
                    ->unionAll($two_sec)
                    ->unionAll($only_table_A)
                    ->orderByRaw('A1, A3, A4')
                    ->get();
    }
}
