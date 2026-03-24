<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateAttempt extends Model
{
    protected $fillable = [
        'session_id',
        'candidate_token',
        'candidate_name',
        'candidate_email',
        'assigned_problem_id',
        'status',
        'started_at',
        'submitted_at',
        'submitted_code',
        'language',
        'score',
        'passed_cases',
        'total_cases',
        'test_results',
        'time_taken_seconds',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'test_results' => 'array',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(TestSession::class, 'session_id');
    }

    public function problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class, 'assigned_problem_id');
    }
}
