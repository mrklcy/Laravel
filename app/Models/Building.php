<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'code',
        'rooms',
        'floors',
        'year_built',
        'total_area',
        'status',
        'manager',
        'notes',
    ];

    protected $casts = [
        'rooms' => 'integer',
        'floors' => 'integer',
        'year_built' => 'integer',
        'total_area' => 'decimal:2',
    ];
}
