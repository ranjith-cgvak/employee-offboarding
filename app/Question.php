<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id',
        'question_number',
        'questions',
        'question_type'
    ];
    public function option()
    {
        return $this->belongsTo('App\Question_option', 'Question_Id', 'question_id');
    }
}
