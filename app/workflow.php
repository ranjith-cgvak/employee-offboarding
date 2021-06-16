<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workflow extends Model
{
    protected $table = "workflows";
    protected $fillable = [
        'mail_type',
        'resignation_department',
        'mail_to_depatment'       
    ];
}