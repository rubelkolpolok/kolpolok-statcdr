<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Apt_event extends Model
{
    protected $fillable = [
        'userID',
        'evtName',
        'evtAddr',
        'evtStart',
        'evtEnd',
        'evtShowWeb'
    ];

    /**
     * Check Current Running Event.
     * If not check Coming Soon event.
     *
     * @param  $currentDateTime string Website Viewer Current Date and Time.
     * @param  $userID int  User ID
     * @return mixed
     */
    public function scopeAvailableEvent($query, $currentDateTime, $userID){
        $allEvent = DB::table("apt_events")
                        ->select('id', 'evtName', 'evtAddr', 'evtStart', 'evtEnd')
                        ->where('userID', '=', $userID)
                        ->where('evtShowWeb', '<=', date('Y-m-d', strtotime($currentDateTime)))
                        ->where('evtEnd', '>=', date('Y-m-d', strtotime($currentDateTime)))
                        ->orderBy('evtStart', 'ASC')
                        ->get()->toArray();
        if(sizeof($allEvent) == 0){
            return -1;
        }else{
            return $allEvent;
        }
    }
}
