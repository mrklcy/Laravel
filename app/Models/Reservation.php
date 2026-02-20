<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'facility',
        'requester',
        'department',
        'reservation_date',
        'start_time',
        'end_time',
        'purpose',
        'attendees',
        'equipment_needed',
        'notes',
        'status',
        'admin_note',
        'reject_reason',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'attendees' => 'integer',
    ];
}
