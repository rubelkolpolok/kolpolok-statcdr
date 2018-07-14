<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Apt_time_slot extends Model
{
    private $agentID;
    protected $fillable = [
        'userID',
        'evtID',
        'agentID',
        'time_slot',
        'slot_duration'
    ];

    /**
     * Check Available Date Slot for specific Event.
     *
     * @param  $eventID int Event ID.
     * @param  $agentID int  Agent ID
     * @return object
     */
    public function scopeAvailableAgentSlotDate($query, $eventID, $agentID){
        $this->agentID = $agentID;
        return DB::table("apt_time_slots AS t")
                    ->leftJoin('apt_lists AS l','l.slotID','=','t.id')
                    ->select('t.id', 't.time_slot')
                    ->where('t.agentID', '=', $this->agentID)
                    ->where('t.evtID', '=', $eventID)
                    ->where('t.time_slot', '>', date('Y-m-d H:i:s'))
                    ->whereNotIn('t.id', function($query){
                        $query->select('slotID')
                                ->distinct()
                                ->where('agentID', '=', $this->agentID)
                                ->from('apt_lists')
                                ->get();
                    })
                    ->orderBy('t.time_slot')
                    ->get();
    }

    /**
     * Check Available Time Slot for specific Event.
     *
     * @param  $eventID int Event ID.
     * @param  $agentID int  Agent ID
     * @param  $dateM string  Meeting Date
     * @return object
     */
    public function scopeAvailableAgentSlotTime($query, $eventID, $agentID, $dateM){
        $this->agentID = $agentID;
        return DB::table("apt_time_slots AS t")
                    ->leftJoin('apt_lists AS l','l.slotID','=','t.id')
                    ->select('t.id', 't.time_slot', 't.slot_duration')
                    ->where('t.agentID', '=', $this->agentID)
                    ->where('t.evtID', '=', $eventID)
                    ->whereDate('t.time_slot', '=', date('Y-m-d', strtotime($dateM)))
                    ->where('t.time_slot', '>', date('Y-m-d H:i:s'))
                    ->whereNotIn('t.id', function($query){
                        $query->select('slotID')
                                ->distinct()
                                ->where('agentID', '=', $this->agentID)
                                ->from('apt_lists')
                                ->get();
                    })
                    ->orderBy('t.time_slot')
                    ->get();
    }
}
