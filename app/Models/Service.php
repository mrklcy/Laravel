<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'details',
        'icon',
        'image',
        'office_id',
        'requirements',
        'process',
        'contact_person',
        'contact_email',
        'contact_phone',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
