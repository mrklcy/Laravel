<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'office_id',
        'position',
        'department',
        'date_hired',
        'employment_status',
        'status',
        'address',
        'birth_date',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'date_hired' => 'date',
        'birth_date' => 'date',
    ];

    /**
     * Get the office that the employee belongs to.
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the employee's full name.
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include regular employees.
     */
    public function scopeRegular($query)
    {
        return $query->where('employment_status', 'regular');
    }
}
