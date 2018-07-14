<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reference extends Model
{
    use Notifiable;

    protected $fillable = ['name','agreement_id','company','designation','phone','email'];

    public function agreement()
    {
        return $this->belongsTo(Agmt_list::class);
    }
}
