<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'office_id',
        'location',
        'event_date',
        'event_end_date',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'datetime',
        'event_end_date' => 'datetime',
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

    public function scopeUpcoming($query)
    {
        return $query->where(function($q) {
            $q->whereNull('event_date')
              ->orWhere('event_date', '>=', now());
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
