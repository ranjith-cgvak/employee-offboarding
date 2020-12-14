<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinalExitChecklist extends Model
{
    protected $fillable = [
        'resignation_id',
        'type_of_exit',
        'date_of_leaving',
        'reason_for_leaving',
        'last_drawn_salary',
        'consider_for_rehire',
        'overall_feedback',
        'relieving_letter',
        'experience_letter',
        'salary_certificate',
        'final_comment',
        'relieving_document',
        'experience_document',
        'salary_document',
        'date_of_entry',
        'updated_by' 
    ];
}
