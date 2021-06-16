<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptanceStatus extends Model
{
    protected $fillable = [
        'resignation_id',
        'acceptance_status',
        'reviewed_by'     
    ];
}
