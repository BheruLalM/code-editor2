<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSession extends Model
{
    protected $fillable = [
        'session_token',
        'title',
        'description',
        'difficulty_filter',
        'time_limit_minutes',
        'is_active',
        'expires_at',
        'max_attempts',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(CandidateAttempt::class, 'session_id');
    }
}
