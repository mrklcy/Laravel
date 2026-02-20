<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicPlan extends Model
{
    protected $fillable = [
        'plan_code',
        'name',
        'description',
        'focus_area',
        'period',
        'start_date',
        'end_date',
        'status',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'progress' => 'integer',
    ];
}
