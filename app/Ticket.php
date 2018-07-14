<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'supportEmail',
        'customerEmail',
        'subject',
        'description'
    ];
}