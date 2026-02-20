<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_code',
        'name',
        'description',
        'category',
        'budget',
        'start_date',
        'end_date',
        'status',
        'progress',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'progress' => 'integer',
    ];
}
