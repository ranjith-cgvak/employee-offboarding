<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowCc extends Model
{
    protected $table = "workflow_cc";
    protected $fillable = [
        'mail_type',
        'resignation_department',
        'cc_emp_id',      
        // mail_type	resignation_department	cc_emp_id
    ];
}
