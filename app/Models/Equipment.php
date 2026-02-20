<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'location',
        'status',
        'condition',
        'assigned_to',
        'notes',
    ];
}
