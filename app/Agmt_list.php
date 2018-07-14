<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agmt_list extends Model
{
    protected $fillable = [
        'userID',
        'agmtTypeID',
        'signatureID',
        'value_a',
        'value_b',
        'value_c',
        'value_d',
        'status',
        'sendMail'
    ];

    public function references()
    {
        return $this->hasMany(Reference::class,'agreement_id');
    }

    public function values()
    {
        return $this->hasMany(Agmt_list_value::class,'agmtListID');
    }

}
