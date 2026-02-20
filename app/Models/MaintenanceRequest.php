<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'request_id',
        'issue',
        'location',
        'priority',
        'status',
        'reporter',
        'description',
        'assigned_to',
        'target_date',
        'assigned_notes',
        'progress_notes',
    ];

    protected $casts = [
        'target_date' => 'date',
    ];
}
