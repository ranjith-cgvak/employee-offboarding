<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'emp_id',
        'commenter_id',
        'skill_set_primary',
        'skill_set_secondary',
        'last_worked_project',
        'attendance_rating',
        'responsiveness_rating',
        'responsibility_rating',
        'commitment_on_task_delivery_rating',
        'technical_knowledge_rating',
        'logical_ability_rating',
        'attitude_rating',
        'overall_rating',
        'comments',
        'feedback_date'   
    ];
}
