<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Dispute;
use DB;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Facades\Excel;

class UploadDisputeFiles extends Command{

    private $disputeData;
    private $ATotalCost = 0.00;
    private $ATotalSec  = 0;
    private $ATotalCall = 0;
    private $AarData    = array();
    private $BTotalCost = 0.00;
    private $BTotalSec  = 0;
    private $BTotalCall = 0;
    private $BarData    = array();
    private $toTimezone = 'Etc/Greenwich';
    private $timeFormat = 'Y-m-d H:i:s';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UploadDisputeFiles:disputefile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Dispute Files One by One, Files information in Database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $currentUploadCheck = DB::table('disputes')
                                        ->select(DB::raw('ID'))
                                        ->where('uploadStatus', '=', -1)
                                        ->get();

        // Check - Is file currently Uploading? if [not] Condition:[true]
        if($currentUploadCheck->count() == 0){
            $readyRowCheck = DB::table('disputes')
                                       ->select(DB::raw('*'))
                                       ->where([['colStatus', '=', 1], ['uploadStatus', '=', 0],])
                                       ->limit(1)->get();

            // Check - Is file ready for Upload? if [yes] Condition:[true]
            if($readyRowCheck->count() == 1){
                $this->disputeData = $readyRowCheck[0];

                DB::table('disputes')
                          ->where('ID', '=',  $this->disputeData->ID)
                          ->update(['uploadStatus' => -1]);


                //DROP database BEFORE CREATE - START
                Schema::dropIfExists($this->disputeData->aTableName);
                Schema::dropIfExists($this->disputeData->bTableName);
                //DROP database BEFORE CREATE - END


                //CREATE Database of Aaa - START
                Schema::create($this->disputeData->aTableName, function (Blueprint $table) {
                    $table->increments('ID');
                    $table->unsignedInteger('disputeID');
                    $table->dateTime('callTime');
                    $table->string('disType', 255)->nullable()->comment('Dispute Type 1:Exact Match, 2:Mismatch by 1sec, 3:Mismatch by 2 Sec, 4:Only A, 5:Only B.');
                    $table->string('bTableID', 255)->nullable()->comment('B Table ID.');
                    $table->string('callerNo', 255)->nullable();
                    $table->string('calledNo', 255)->nullable();
                    $table->string('duration', 255)->nullable();
                    $table->string('callRate', 255)->nullable();
                    $table->string('callCost', 255)->nullable();
                    $table->timestamps();
                    $table->foreign('disputeID')->references('ID')->on('disputes')->onDelete('cascade')->onUpdate('cascade');
                    $table->index(['disputeID', 'callerNo', 'calledNo', 'duration'],'add_index');
                });
                //CREATE Database of Aaa - END


                //CREATE Database of Bee - START
                Schema::create($this->disputeData->bTableName, function (Blueprint $table) {
                    $table->increments('ID');
                    $table->unsignedInteger('disputeID');
                    $table->dateTime('callTime');
                    $table->string('disType', 255)->nullable()->comment('Dispute Type 1:Exact Match, 2:Mismatch by 1sec, 3:Mismatch by 2 Sec, 4:Only A, 5:Only B.');
                    $table->string('callerNo', 255)->nullable();
                    $table->string('calledNo', 255)->nullable();
                    $table->string('duration', 255)->nullable();
                    $table->string('callRate', 255)->nullable();
                    $table->string('callCost', 255)->nullable();
                    $table->timestamps();
                    $table->foreign('disputeID')->references('ID')->on('disputes')->onDelete('cascade')->onUpdate('cascade');
                    $table->index(['disputeID', 'callerNo', 'calledNo', 'duration'],'add_index');
                });
                //CREATE Database of Bee - END


                $aFilePath = storage_path('public/uploads/disputes//' . $this->disputeData->aFile);
                $bFilePath = storage_path('public/uploads/disputes//' . $this->disputeData->bFile);

                /*
                 * Aaa Excel to PHP Array - START.
                 */
                Excel::selectSheetsByIndex(0)->load($aFilePath, function ($reader) {
                    $AKey = 0;
                    foreach($reader->toArray() as $key2 => $value2){
                        $column = 1;
                        foreach($value2 as $key3 => $value3){

                            if($column == $this->disputeData->aDateColNo){
                                if(is_string($value3)){
                                    $date = $value3;
                                }else{
                                    $date = $value3->toArray();
                                    $date = $date["formatted"];
                                }
                                $dt = new DateTime(date($this->timeFormat, strtotime($date)), new DateTimeZone($this->disputeData->aDateZone));
                                $dt->setTimeZone(new DateTimeZone($this->toTimezone));
                                $this->AarData[$AKey][0] = $dt->format($this->timeFormat);

                            }elseif($column == $this->disputeData->aCallerColNo){
                                if(is_numeric($value3)){
                                    $this->AarData[$AKey][1] = number_format($value3,0,'','');
                                }else{
                                    $this->AarData[$AKey][1] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->aCalledColNo){
                                if(is_numeric($value3)){
                                    $this->AarData[$AKey][2] = number_format($value3,0,'','');
                                    if(substr($this->AarData[$AKey][2], 0, strlen($this->disputeData->aCalledPrefix)) == $this->disputeData->aCalledPrefix) {
                                        $this->AarData[$AKey][2] = substr($this->AarData[$AKey][2], strlen($this->disputeData->aCalledPrefix));
                                    }
                                }else{
                                    $this->AarData[$AKey][2] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->aDurationColNo){
                                if(is_numeric($value3)){
                                    $this->AarData[$AKey][3] = number_format($value3,0,'','');
                                    $this->ATotalSec        += $this->AarData[$AKey][3];
                                }else{
                                    $this->AarData[$AKey][3] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->aRateColNo){
                                if(is_numeric($value3)){
                                    $this->AarData[$AKey][4] = str_replace(' ', '', $value3);
                                }else{
                                    $this->AarData[$AKey][4] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->aCostColNo){
                                if(is_numeric($value3)){
                                    $this->AarData[$AKey][5] = str_replace(' ', '', $value3);
                                    $this->ATotalCost       += $this->AarData[$AKey][5];
                                }else{
                                    $this->AarData[$AKey][5] = str_replace(' ', '', $value3);
                                }
                            }
                            $column++;
                        }
                        DB::table($this->disputeData->aTableName)->insert([
                            'disputeID' => $this->disputeData->ID,
                            'callTime' => $this->AarData[$AKey][0],
                            'callerNo' => $this->AarData[$AKey][1],
                            'calledNo' => $this->AarData[$AKey][2],
                            'duration' => $this->AarData[$AKey][3],
                            'callRate' => isset($this->AarData[$AKey][4])?$this->AarData[$AKey][4]:0,
                            'callCost' => isset($this->AarData[$AKey][5])?$this->AarData[$AKey][5]:0
                        ]);
                        $AKey++;
                        $this->ATotalCall++;
                    }
                });
                /*
                 * Aaa Excel to PHP Array - END.
                 */


                /*
                 * Bee Excel to PHP Array - START.
                 */
                Excel::selectSheetsByIndex(0)->load($bFilePath, function ($reader) {
                    $BKey = 0;
                    foreach($reader->toArray() as $key2 => $value2){
                        $column = 1;
                        foreach($value2 as $key3 => $value3){

                            if($column == $this->disputeData->bDateColNo){
                                if(is_string($value3)){
                                    $date = $value3;
                                }else{
                                    $date = $value3->toArray();
                                    $date = $date["formatted"];
                                }
                                $dt = new DateTime(date($this->timeFormat, strtotime($date)), new DateTimeZone($this->disputeData->bDateZone));
                                $dt->setTimeZone(new DateTimeZone($this->toTimezone));
                                $this->BarData[$BKey][0] = $dt->format($this->timeFormat);

                            }elseif($column == $this->disputeData->bCallerColNo){
                                if(is_numeric($value3)){
                                    $this->BarData[$BKey][1] = number_format($value3,0,'','');
                                }else{
                                    $this->BarData[$BKey][1] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->bCalledColNo){
                                if(is_numeric($value3)){
                                    $this->BarData[$BKey][2] = number_format($value3,0,'','');
                                    if(substr($this->BarData[$BKey][2], 0, strlen($this->disputeData->bCalledPrefix)) == $this->disputeData->bCalledPrefix) {
                                        $this->BarData[$BKey][2] = substr($this->BarData[$BKey][2], strlen($this->disputeData->bCalledPrefix));
                                    }
                                }else{
                                    $this->BarData[$BKey][2] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->bDurationColNo){
                                if(is_numeric($value3)){
                                    $this->BarData[$BKey][3] = number_format($value3,0,'','');
                                    $this->BTotalSec        += $this->BarData[$BKey][3];
                                }else{
                                    $this->BarData[$BKey][3] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->bRateColNo){
                                if(is_numeric($value3)){
                                    $this->BarData[$BKey][4] = str_replace(' ', '', $value3);
                                }else{
                                    $this->BarData[$BKey][4] = str_replace(' ', '', $value3);
                                }

                            }elseif($column == $this->disputeData->bCostColNo){
                                if(is_numeric($value3)){
                                    $this->BarData[$BKey][5] = str_replace(' ', '', $value3);
                                    $this->BTotalCost       += $this->BarData[$BKey][5];
                                }else{
                                    $this->BarData[$BKey][5] = str_replace(' ', '', $value3);
                                }
                            }
                            $column++;
                        }
                        DB::table($this->disputeData->bTableName)->insert([
                            'disputeID' => $this->disputeData->ID,
                            'callTime' => $this->BarData[$BKey][0],
                            'callerNo' => $this->BarData[$BKey][1],
                            'calledNo' => $this->BarData[$BKey][2],
                            'duration' => $this->BarData[$BKey][3],
                            'callRate' => isset($this->BarData[$BKey][4])?$this->BarData[$BKey][4]:0,
                            'callCost' => isset($this->BarData[$BKey][5])?$this->BarData[$BKey][5]:0
                        ]);
                        $BKey++;
                        $this->BTotalCall++;
                    }
                });
                /*
                 * Bee Excel to PHP Array - END.
                 */


                DB::table('disputes')
                    ->where('ID', '=',  $this->disputeData->ID)
                    ->update([
                        'aTotalCall' => $this->ATotalCall,
                        'bTotalCall' => $this->BTotalCall,
                        'aTotalSec' => $this->ATotalSec,
                        'bTotalSec' => $this->BTotalSec,
                        'aTotalCost' => $this->ATotalCost,
                        'bTotalCost' => $this->BTotalCost
                    ]);

                DB::table('sdr_dispute_summery')->where('disputeID', '=', $this->disputeData->ID)->delete();

                // Dispute Calculation
                $disputeCal = Dispute::disputeScript($this->disputeData->aTableName, $this->disputeData->bTableName);

                // Exact Match
                DB::table('sdr_dispute_summery')->insert([
                    'userID' => $this->disputeData->userID,
                    'disputeID' => $this->disputeData->ID,
                    'disputeType' => 1,
                    'A1' => $disputeCal[1][0],
                    'A2' => $disputeCal[1][1],
                    'A3' => $disputeCal[1][3],
                    'B1' => $disputeCal[1][0],
                    'B2' => $disputeCal[1][2],
                    'B3' => $disputeCal[1][4]
                ]);


                // Mismatch by Duration( = 1 Sec)
                DB::table('sdr_dispute_summery')->insert([
                    'userID' => $this->disputeData->userID,
                    'disputeID' => $this->disputeData->ID,
                    'disputeType' => 2,
                    'A1' => $disputeCal[2][0],
                    'A2' => $disputeCal[2][1],
                    'A3' => $disputeCal[2][3],
                    'B1' => $disputeCal[2][0],
                    'B2' => $disputeCal[2][2],
                    'B3' => $disputeCal[2][4]
                ]);


                // Mismatch by Duration( = 2 Sec)
                DB::table('sdr_dispute_summery')->insert([
                    'userID' => $this->disputeData->userID,
                    'disputeID' => $this->disputeData->ID,
                    'disputeType' => 3,
                    'A1' => $disputeCal[3][0],
                    'A2' => $disputeCal[3][1],
                    'A3' => $disputeCal[3][3],
                    'B1' => $disputeCal[3][0],
                    'B2' => $disputeCal[3][2],
                    'B3' => $disputeCal[3][4]
                ]);


                // Present in Table One CDR Only
                DB::table('sdr_dispute_summery')->insert([
                    'userID' => $this->disputeData->userID,
                    'disputeID' => $this->disputeData->ID,
                    'disputeType' => 4,
                    'A1' => $disputeCal[4][0],
                    'A2' => $disputeCal[4][1],
                    'A3' => $disputeCal[4][3]
                ]);


                // Present in Table Two CDR Only
                DB::table('sdr_dispute_summery')->insert([
                    'userID' => $this->disputeData->userID,
                    'disputeID' => $this->disputeData->ID,
                    'disputeType' => 5,
                    'A1' => $disputeCal[5][0],
                    'A2' => $disputeCal[5][2],
                    'A3' => $disputeCal[5][4]
                ]);


                DB::table('disputes')
                    ->where('ID', '=', $this->disputeData->ID)
                    ->update([
                        'uploadStatus' => 1
                    ]);
            }
        }
    }
}
