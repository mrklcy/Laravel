<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'reference_no',
        'file_path',
        'file_name',
        'file_size',
        'status',
        'uploaded_by',
        'archived_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'archived_at' => 'datetime',
    ];

    /**
     * Scope: only active documents.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: only archived documents.
     */
    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Get the uploader (admin).
     */
    public function uploader()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }
}
