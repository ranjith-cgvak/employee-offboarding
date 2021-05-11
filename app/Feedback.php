<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'resignation_id',
        'attribute',
        'comment_rating'
    ];
}
