<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apt_list extends Model
{
    protected $fillable = [
        'userID',
        'evtID',
        'agentID',
        'slotID',
        'cusName',
        'cusEmail',
        'cusPhn',
        'cusCom',
        'cusSkype'
    ];
}
