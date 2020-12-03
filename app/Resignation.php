<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    protected $fillable = [
        'reason',
        'comment_on_resignation',
        'date_of_leaving',
        'date_of_resignation'     
    ];
}
