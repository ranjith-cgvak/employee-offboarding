<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'resignation_id',
        'comment_type',
        'comment_by',
        'comment'  
    ];
}
