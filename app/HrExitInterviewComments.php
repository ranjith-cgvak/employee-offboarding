<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrExitInterviewComments extends Model
{
    protected $fillable = [
        'resignation_id',
        'comments',
        'action_area',
        'commented_by'
    ];
}
