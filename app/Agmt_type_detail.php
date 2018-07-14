<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agmt_type_detail extends Model
{
    protected $fillable = [
        'userID',
        'agmtTypeID',
        'columnName',
        'placeHolder',
        'columnType',
        'mustFill'
    ];
}
