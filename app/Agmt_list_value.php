<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agmt_list_value extends Model
{
    protected $fillable = [
        'userID',
        'agmtListID',
        'agmtTypeColumnID',
        'columnValue'
    ];

    public function agreement()
    {
        return $this->belongsTo(Agmt_list::class);
    }
}
