<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoDue extends Model
{
    protected $fillable = [
        'resignation_id',
        'attribute',
        'comment'
    ];
}
