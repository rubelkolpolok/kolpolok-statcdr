<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agmt_list_upload extends Model
{
    protected $fillable = [
        'userID',
        'agmtListID',
        'fileName'
    ];
}
