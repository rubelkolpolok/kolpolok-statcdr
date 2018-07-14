<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_reply extends Model
{
    protected $fillable = [
        'ticketID',
        'description',
        'replyEmail'
    ];
}
