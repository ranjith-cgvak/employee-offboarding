<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOptions extends Model
{
    protected $fillable = [
        'question_id',
        'option_value'   
    ];
}
