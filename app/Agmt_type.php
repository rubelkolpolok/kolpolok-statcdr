<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agmt_type extends Model
{
    protected $fillable = [
        'userID',
        'typeName',
        'adminApprove',
        'showOrder',
        'pdfDetails'
    ];
}
