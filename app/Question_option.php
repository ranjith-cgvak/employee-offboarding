<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question_option extends Model
{
    protected $table = "options";
    protected $fillable = [
        'option_id',
        'question_id',
        'qption_value'       
    ];
}