<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class questionType extends Model
{
    protected $table = "question_types";
    protected $fillable = [
        'Type_id',
        'Type'

    ];
}
