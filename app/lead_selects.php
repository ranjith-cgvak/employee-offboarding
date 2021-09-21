<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lead_selects extends Model
{
    //
    protected $table = "lead_selects";
    protected $fillable = [
        'department_name',
        'emp_id',
        'assigned_to'
    ];

}
