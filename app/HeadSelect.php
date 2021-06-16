<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeadSelect extends Model
{
    protected $table = "head_selects";
    protected $fillable = [
        'department_name',
        'emp_id'
    ];
}
